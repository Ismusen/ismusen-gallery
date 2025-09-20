jQuery(document).ready(function($) {
    // 灯箱功能
    let currentImageIndex = 0;
    let images = [];
    
    // 从本地化数据获取图片
    if (typeof ismusenGallery !== 'undefined' && ismusenGallery.galleryData) {
        images = ismusenGallery.galleryData.images || [];
    }
    
    // 设置筛选功能
    $(".filter-btn").click(function() {
        // 更新活动按钮
        $(".filter-btn").removeClass("active");
        $(this).addClass("active");
        
        const filter = $(this).data("filter");
        
        // 筛选图片
        $(".album-item").each(function() {
            if (filter === "all" || $(this).data("category") === filter) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    
    // 设置灯箱功能
    const lightbox = $(".lightbox");
    const lightboxImg = $(".lightbox-content img");
    const lightboxCaption = $(".lightbox-caption");
    const lightboxClose = $(".lightbox-close");
    const lightboxPrev = $(".lightbox-prev");
    const lightboxNext = $(".lightbox-next");
    
    // 图片点击事件
    $(".album-item").click(function() {
        const id = $(this).data("id");
        const index = images.findIndex(img => img.id === id);
        
        if (index !== -1) {
            openLightbox(index);
        }
    });
    
    // 打开灯箱
    function openLightbox(index) {
        currentImageIndex = index;
        const image = images[currentImageIndex];
        
        lightboxImg.attr("src", image.src);
        lightboxCaption.text(image.title + " - " + image.desc);
        lightbox.addClass("open");
        
        $("body").css("overflow", "hidden");
    }
    
    // 关闭灯箱
    function closeLightbox() {
        lightbox.removeClass("open");
        $("body").css("overflow", "auto");
    }
    
    // 下一张图片
    function nextImage() {
        currentImageIndex = (currentImageIndex + 1) % images.length;
        const image = images[currentImageIndex];
        
        lightboxImg.attr("src", image.src);
        lightboxCaption.text(image.title + " - " + image.desc);
    }
    
    // 上一张图片
    function prevImage() {
        currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
        const image = images[currentImageIndex];
        
        lightboxImg.attr("src", image.src);
        lightboxCaption.text(image.title + " - " + image.desc);
    }
    
    // 绑定事件
    lightboxClose.click(closeLightbox);
    lightbox.click(function(e) {
        if (e.target === this) {
            closeLightbox();
        }
    });
    
    lightboxPrev.click(function(e) {
        e.stopPropagation();
        prevImage();
    });
    
    lightboxNext.click(function(e) {
        e.stopPropagation();
        nextImage();
    });
    
    // 键盘导航
    $(document).keydown(function(e) {
        if (lightbox.hasClass("open")) {
            if (e.key === "Escape") {
                closeLightbox();
            } else if (e.key === "ArrowRight") {
                nextImage();
            } else if (e.key === "ArrowLeft") {
                prevImage();
            }
        }
    });
});