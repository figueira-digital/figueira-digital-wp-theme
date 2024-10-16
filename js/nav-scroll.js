(function() {
    function handleNavScroll() {
        const nav = document.getElementById('site-navigation');
        
        function updateNavPosition() {
            nav.style.position = 'fixed';
            nav.style.top = '0';
            nav.style.right = '5%';
        }

        window.addEventListener('scroll', updateNavPosition);
        window.addEventListener('resize', updateNavPosition);
        updateNavPosition();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', handleNavScroll);
    } else {
        handleNavScroll();
    }
})();