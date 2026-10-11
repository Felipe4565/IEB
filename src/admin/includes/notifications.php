<?php foreach (['success', 'error'] as $k): if (isset($_SESSION[$k])): ?>
    <div class="toast-notification js-toast" <?= $k === 'error' ? 'style="border-left-color:#ff5f40"' : '' ?>>
        <span><?= htmlspecialchars($_SESSION[$k]) ?></span>
    </div>
<?php unset($_SESSION[$k]); endif; endforeach; ?>
<script>
    setTimeout(() => document.querySelectorAll('.js-toast').forEach(t => {
        t.style.opacity = '0'; t.style.transition = 'opacity 0.5s ease';
        setTimeout(() => t.remove(), 500);
    }), 4000);
</script>