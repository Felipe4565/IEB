<?php
if (isset($_SESSION['success'])): ?>
    <div id="toast" class="toast-notification">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#c5a67c" stroke-width="2">
            <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
        <span><?php echo $_SESSION['success']; ?></span>
    </div>
    
    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if(toast) {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.5s ease';
                setTimeout(() => toast.remove(), 500);
            }
        }, 4000);
    </script>
    <?php 
    unset($_SESSION['success']); 
    ?>
<?php endif; ?>