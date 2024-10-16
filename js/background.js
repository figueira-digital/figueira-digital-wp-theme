(function() {
    const initBackground = () => {
        const uniforms = {
            u_time: { value: 0.0 },
            u_mouse: {
                value: {
                    x: 0.0,
                    y: 0.0
                }
            },
            u_scroll: { value: 0.0 },
            u_resolution: { value: new THREE.Vector2() },
            u_pointsize: { value: 2.0 },
            u_noise_freq_1: { value: 3.0 },
            u_noise_amp_1: { value: 0.2 },
            u_spd_modifier_1: { value: 0.5 },
            u_noise_freq_2: { value: 2.0 },
            u_noise_amp_2: { value: 0.3 },
            u_spd_modifier_2: { value: 0.8 }
        };

        const scene = new THREE.Scene();
        const renderer = new THREE.WebGLRenderer({ antialias: true });
        renderer.setPixelRatio(window.devicePixelRatio);
        renderer.setSize(window.innerWidth, window.innerHeight);

        const fov = 45;
        const near = 0.1;
        const far = 100;
        const camPos = { x: 0, y: 0, z: -1 };
        const camLookAt = { x: 0, y: 0, z: -2 };
        const aspect = window.innerWidth / window.innerHeight;
        const camera = new THREE.PerspectiveCamera(fov, aspect, near, far);
        camera.position.set(camPos.x, camPos.y, camPos.z);
        camera.lookAt(camLookAt.x, camLookAt.y, camLookAt.z);
        camera.updateProjectionMatrix();

        const vertexShader = `
            #define PI 3.14159265359

            uniform float u_time;
            uniform vec2 u_mouse;
            uniform float u_scroll;
            uniform vec2 u_resolution;
            uniform float u_pointsize;
            uniform float u_noise_freq_1;
            uniform float u_noise_amp_1;
            uniform float u_spd_modifier_1;
            uniform float u_noise_freq_2;
            uniform float u_noise_amp_2;
            uniform float u_spd_modifier_2;

            varying vec2 vUv;

            // 2D Random
            float random (in vec2 st) {
                return fract(sin(dot(st.xy,
                                    vec2(12.9898,78.233)))
                            * 43758.5453123);
            }

            // 2D Noise based on Morgan McGuire @morgan3d
            // https://www.shadertoy.com/view/4dS3Wd
            float noise (in vec2 st) {
                vec2 i = floor(st);
                vec2 f = fract(st);

                // Four corners in 2D of a tile
                float a = random(i);
                float b = random(i + vec2(1.0, 0.0));
                float c = random(i + vec2(0.0, 1.0));
                float d = random(i + vec2(1.0, 1.0));

                // Smooth Interpolation

                // Cubic Hermine Curve.  Same as SmoothStep()
                vec2 u = f*f*(3.0-2.0*f);
                // u = smoothstep(0.,1.,f);

                // Mix 4 coorners percentages
                return mix(a, b, u.x) +
                        (c - a)* u.y * (1.0 - u.x) +
                        (d - b) * u.x * u.y;
            }

            void main() {
              vUv = uv;
              gl_PointSize = u_pointsize;

              vec3 pos = position;
              
              // Apply first noise layer
              pos.z += noise(pos.xy * u_noise_freq_1 + u_time * u_spd_modifier_1) * u_noise_amp_1;
              
              // Apply second noise layer
              pos.z += noise(pos.xy * u_noise_freq_2 + u_time * u_spd_modifier_2) * u_noise_amp_2;
              
              // Add infinite scroll effect
              float scrollOffset = mod(u_scroll * 0.01, 2.0) - 1.0;
              pos.y += scrollOffset;

              // Add mouse effect
              vec2 mouseEffect = (u_mouse / u_resolution - 0.5) * 2.0;
              pos.xy += mouseEffect * 0.1;

              vec4 mvPosition = modelViewMatrix * vec4(pos, 1.0);
              gl_Position = projectionMatrix * mvPosition;
            }
        `;

        const fragmentShader = `
            uniform vec2 u_resolution;
            varying vec2 vUv;

            void main() {
              vec2 st = gl_FragCoord.xy / u_resolution;
              gl_FragColor = vec4(vUv, 0.5, 1.0);
            }
        `;

        const initScene = async () => {
            scene.background = new THREE.Color("#0d1214");

            const geometry = new THREE.PlaneGeometry(8, 8, 512, 512);
            const material = new THREE.ShaderMaterial({
                uniforms: uniforms,
                vertexShader: vertexShader,
                fragmentShader: fragmentShader,
                transparent: true
            });
            const mesh = new THREE.Points(geometry, material);
            scene.add(mesh);
            mesh.position.set(0, 0, -1);
            mesh.rotation.x = 3.1415 / 1.7;
        };

        const container = document.getElementById("background-container");
        container.appendChild(renderer.domElement);
        container.style.position = 'fixed';
        container.style.top = '0';
        container.style.left = '0';
        container.style.width = '100%';
        container.style.height = '100%';
        container.style.zIndex = '-1';

        const onWindowResize = () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
            uniforms.u_resolution.value.x = window.innerWidth * window.devicePixelRatio;
            uniforms.u_resolution.value.y = window.innerHeight * window.devicePixelRatio;
        };

        window.addEventListener("resize", onWindowResize);
        onWindowResize();

        const mouseListener = (e) => {
            uniforms.u_mouse.value.x = e.touches ? e.touches[0].clientX : e.clientX;
            uniforms.u_mouse.value.y = e.touches ? e.touches[0].clientY : e.clientY;
        };

        if ("ontouchstart" in window) {
            window.addEventListener("touchmove", mouseListener);
        } else {
            window.addEventListener("mousemove", mouseListener);
        }

        // Add scroll listener
        window.addEventListener('scroll', () => {
            uniforms.u_scroll.value = window.pageYOffset;
        });

        const clock = new THREE.Clock();
        const animate = () => {
            requestAnimationFrame(animate);
            const delta = clock.getDelta();
            const elapsed = clock.getElapsedTime();
            uniforms.u_time.value = elapsed;

            renderer.render(scene, camera);
        };

        initScene()
            .then(() => {
                const veil = document.getElementById("veil");
                if (veil) veil.style.opacity = 0;
                return true;
            })
            .then(animate)
            .catch((error) => {
                console.log(error);
            });
    };

    // Wait for the DOM to be fully loaded before initializing
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initBackground);
    } else {
        initBackground();
    }
})();