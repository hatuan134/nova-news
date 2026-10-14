<footer class="site-footer">
    <div class="container footer-top">
        <div>
            <a class="footer-brand" href="<?php echo esc_url(home_url('/')); ?>">NOVA<span>NEWS</span><i>✦</i></a>
            <p>Góc nhìn rõ ràng. Câu chuyện có chiều sâu.<br>Những điều đáng đọc, mỗi ngày.</p>
        </div>
        <div class="footer-links">
            <div><h3>Khám phá</h3><a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a><a href="<?php echo esc_url(get_post_type_archive_link('post') ?: home_url('/')); ?>">Tin mới nhất</a></div>
            <div><h3>Thông tin</h3><span>Website thực hành</span><span>Môn Triển khai & Quản trị HTPM</span></div>
        </div>
    </div>
    <div class="container footer-bottom"><span>© <?php echo esc_html(wp_date('Y')); ?> NOVA NEWS. Dự án học tập.</span><span>Được phát triển trên WordPress.</span></div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
