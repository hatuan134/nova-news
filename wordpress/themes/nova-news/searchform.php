<form class="search-form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
    <label class="screen-reader-text" for="nova-search">Tìm kiếm bài viết</label>
    <input id="nova-search" type="search" name="s" placeholder="Tìm bài viết, chủ đề, tác giả..." value="<?php echo esc_attr(get_search_query()); ?>" required>
    <button type="submit">Tìm kiếm →</button>
</form>
