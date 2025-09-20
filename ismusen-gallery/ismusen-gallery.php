<?php
/**
 * Plugin Name: Ismusen相册插件
 * Plugin URI: https://ismusen.com
 * Description: 为Ismusen博客定制的精美相册插件 - 优化版
 * Version: 1.1.0
 * Author: Ismusen
 * Author URI: https://ismusen.com
 * License: GPL v2 or later
 * Text Domain: ismusen-gallery
 */

// 防止直接访问
if (!defined('ABSPATH')) {
    exit;
}

// 定义插件常量
define('ISMUSEN_GALLERY_VERSION', '1.1.0');
define('ISMUSEN_GALLERY_PLUGIN_URL', plugin_dir_url(__FILE__));
define('ISMUSEN_GALLERY_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('ISMUSEN_GALLERY_IMAGE_DIR', ISMUSEN_GALLERY_PLUGIN_PATH . 'images/');
define('ISMUSEN_GALLERY_IMAGE_URL', ISMUSEN_GALLERY_PLUGIN_URL . 'images/');

// 创建图片目录
if (!file_exists(ISMUSEN_GALLERY_IMAGE_DIR)) {
    wp_mkdir_p(ISMUSEN_GALLERY_IMAGE_DIR);
}

// 注册激活和停用钩子
register_activation_hook(__FILE__, 'ismusen_gallery_activate');
register_deactivation_hook(__FILE__, 'ismusen_gallery_deactivate');

function ismusen_gallery_activate() {
    // 初始化默认数据
    $default_data = array(
        'categories' => array(
            array('id' => 'nature', 'name' => '自然'),
            array('id' => 'urban', 'name' => '城市'),
            array('id' => 'portrait', 'name' => '人物'),
            array('id' => 'travel', 'name' => '旅行')
        ),
        'images' => array(
            // 自然类图片 (10张)
            array('id' => 1, 'src' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '落基山脉', 'desc' => '加拿大, 2023', 'category' => 'nature', 'orientation' => 'landscape'),
            array('id' => 2, 'src' => 'https://images.unsplash.com/photo-1418065460487-3e41a6c84dc5?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '森林晨曦', 'desc' => '挪威, 2023', 'category' => 'nature', 'orientation' => 'landscape'),
            array('id' => 3, 'src' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '宁静湖泊', 'desc' => '瑞士, 2023', 'category' => 'nature', 'orientation' => 'landscape'),
            array('id' => 4, 'src' => 'https://images.unsplash.com/photo-1433086966358-54859d0ed716?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '瀑布奇观', 'desc' => '巴西, 2022', 'category' => 'nature', 'orientation' => 'landscape'),
            array('id' => 5, 'src' => 'https://images.unsplash.com/photo-1505832018823-50331d70d237?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '沙漠之旅', 'desc' => '迪拜, 2022', 'category' => 'nature', 'orientation' => 'landscape'),
            array('id' => 6, 'src' => 'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '壮丽山川', 'desc' => '新西兰, 2022', 'category' => 'nature', 'orientation' => 'landscape'),
            array('id' => 7, 'src' => 'https://images.unsplash.com/photo-1465146344425-f00d5f5c8f07?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '迷雾森林', 'desc' => '德国, 2022', 'category' => 'nature', 'orientation' => 'landscape'),
            array('id' => 8, 'src' => 'https://images.unsplash.com/photo-1506260408121-e353d10b87c7?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '北极光', 'desc' => '冰岛, 2022', 'category' => 'nature', 'orientation' => 'landscape'),
            array('id' => 9, 'src' => 'https://images.unsplash.com/photo-1470240731273-7821a6eeb6bd?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '秋日色彩', 'desc' => '日本, 2022', 'category' => 'nature', 'orientation' => 'landscape'),
            array('id' => 10, 'src' => 'https://images.unsplash.com/photo-1426170042593-200f250dfdaf?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '海岸线', 'desc' => '澳大利亚, 2022', 'category' => 'nature', 'orientation' => 'landscape'),
            
            // 城市类图片 (10张)
            array('id' => 11, 'src' => 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '城市之夜', 'desc' => '纽约, 2023', 'category' => 'urban', 'orientation' => 'landscape'),
            array('id' => 12, 'src' => 'https://images.unsplash.com/photo-1449824913935-59a10b8d2000?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '都市线条', 'desc' => '芝加哥, 2023', 'category' => 'urban', 'orientation' => 'landscape'),
            array('id' => 13, 'src' => 'https://images.unsplash.com/photo-1519501025264-65ba15a82390?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '都市风光', 'desc' => '东京, 2023', 'category' => 'urban', 'orientation' => 'landscape'),
            array('id' => 14, 'src' => 'https://images.unsplash.com/photo-1513584684374-8bab748fbf90?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '夜色都市', 'desc' => '香港, 2023', 'category' => 'urban', 'orientation' => 'landscape'),
            array('id' => 15, 'src' => 'https://images.unsplash.com/photo-1496568816309-51d7c20e3b21?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '街头巷尾', 'desc' => '伦敦, 2023', 'category' => 'urban', 'orientation' => 'landscape'),
            array('id' => 16, 'src' => 'https://images.unsplash.com/photo-1519677100203-a0e668c92439?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '现代建筑', 'desc' => '上海, 2023', 'category' => 'urban', 'orientation' => 'landscape'),
            array('id' => 17, 'src' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '城市全景', 'desc' => '旧金山, 2022', 'category' => 'urban', 'orientation' => 'landscape'),
            array('id' => 18, 'src' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '商业中心', 'desc' => '新加坡, 2022', 'category' => 'urban', 'orientation' => 'landscape'),
            array('id' => 19, 'src' => 'https://images.unsplash.com/photo-1444723121867-7a241cacace9?ixlib=rb-1.2.1&auto=format&fit=c crop&w=500&q=80', 'title' => '城市动脉', 'desc' => '首尔, 2022', 'category' => 'urban', 'orientation' => 'landscape'),
            array('id' => 20, 'src' => 'https://images.unsplash.com/photo-1470219556762-1771e7f9427d?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '城市广场', 'desc' => '巴塞罗那, 2022', 'category' => 'urban', 'orientation' => 'landscape'),
            
            // 人物类图片 (10张)
            array('id' => 21, 'src' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '沉思', 'desc' => '巴黎, 2023', 'category' => 'portrait', 'orientation' => 'portrait'),
            array('id' => 22, 'src' => 'https://images.unsplash.com/photo-1552058544-f2b08422138a?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '微笑', 'desc' => '罗马, 2023', 'category' => 'portrait', 'orientation' => 'portrait'),
            array('id' => 23, 'src' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '凝视', 'desc' => '柏林, 2023', 'category' => 'portrait', 'orientation' => 'portrait'),
            array('id' => 24, 'src' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '优雅', 'desc' => '米兰, 2023', 'category' => 'portrait', 'orientation' => 'portrait'),
            array('id' => 25, 'src' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&auto=format&fit=c crop&w=500&q=80', 'title' => '特写', 'desc' => '马德里, 2023', 'category' => 'portrait', 'orientation' => 'portrait'),
            array('id' => 26, 'src' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '自然光人像', 'desc' => '里斯本, 2022', 'category' => 'portrait', 'orientation' => 'portrait'),
            array('id' => 27, 'src' => 'https://images.unsplash.com/photo-1491349174775-aaafddd81942?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '街头人像', 'desc' => '阿姆斯特丹, 2022', 'category' => 'portrait', 'orientation' => 'portrait'),
            array('id' => 28, 'src' => 'https://images.unsplash.com/photo-1488426862026-3ee34a7d66df?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '职业肖像', 'desc' => '维也纳, 2022', 'category' => 'portrait', 'orientation' => 'portrait'),
            array('id' => 29, 'src' => 'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '艺术人像', 'desc' => '布拉格, 2022', 'category' => 'portrait', 'orientation' => 'portrait'),
            array('id' => 30, 'src' => 'https://images.unsplash.com/photo-1545912452-8aea7e25a3d3?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '黑白人像', 'desc' => '布达佩斯, 2022', 'category' => 'portrait', 'orientation' => 'portrait'),
            
            // 旅行类图片 (10张)
            array('id' => 31, 'src' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '旅途记忆', 'desc' => '冰岛, 2023', 'category' => 'travel', 'orientation' => 'landscape'),
            array('id' => 32, 'src' => 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '旅途风景', 'desc' => '希腊, 2023', 'category' => 'travel', 'orientation' => 'landscape'),
            array('id' => 33, 'src' => 'https://images.unsplash.com/photo-1516483638261-f4dbaf036963?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '意大利小镇', 'desc' => '意大利, 2022', 'category' => 'travel', 'orientation' => 'landscape'),
            array('id' => 34, 'src' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '热带海滩', 'desc' => '泰国, 2022', 'category' => 'travel', 'orientation' => 'landscape'),
            array('id' => 35, 'src' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '自然奇观', 'desc' => '肯尼亚, 2022', 'category' => 'travel', 'orientation' => 'landscape'),
            array('id' => 36, 'src' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '海滩日落', 'desc' => '巴厘岛, 2022', 'category' => 'travel', 'orientation' => 'landscape'),
            array('id' => 37, 'src' => 'https://images.unsplash.com/photo-1467269204594-9661b134dd2b?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '旅行冒险', 'desc' => '秘鲁, 2022', 'category' => 'travel', 'orientation' => 'landscape'),
            array('id' => 38, 'src' => 'https://images.unsplash.com/photo-1501555088652-021faa106b9b?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '高山旅行', 'desc' => '尼泊尔, 2022', 'category' => 'travel', 'orientation' => 'landscape'),
            array('id' => 39, 'src' => 'https://images.unsplash.com/photo-1506929562872-bb421503ef21?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '沙漠旅行', 'desc' => '摩洛哥, 2022', 'category' => 'travel', 'orientation' => 'landscape'),
            array('id' => 40, 'src' => 'https://images.unsplash.com/photo-1418065460487-3e41a6c84dc5?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80', 'title' => '森林徒步', 'desc' => '加拿大, 2022', 'category' => 'travel', 'orientation' => 'landscape')
        )
    );
    
    // 如果不存在，则保存默认数据
    if (!get_option('ismusen_gallery_data')) {
        update_option('ismusen_gallery_data', $default_data);
    }
}

function ismusen_gallery_deactivate() {
    // 清理操作（可选）
}

// 初始化插件
add_action('init', 'ismusen_gallery_init');

function ismusen_gallery_init() {
    // 注册短代码
    add_shortcode('ismusen_gallery', 'ismusen_gallery_shortcode');
    
    // 添加管理菜单
    if (is_admin()) {
        add_action('admin_menu', 'ismusen_gallery_admin_menu');
        add_action('admin_enqueue_scripts', 'ismusen_gallery_admin_scripts');
        add_action('wp_ajax_ismusen_gallery_upload', 'ismusen_gallery_handle_upload');
    } else {
        add_action('wp_enqueue_scripts', 'ismusen_gallery_frontend_scripts');
    }
}

// 前端脚本和样式
function ismusen_gallery_frontend_scripts() {
    wp_enqueue_style('ismusen-gallery-style', 
        ISMUSEN_GALLERY_PLUGIN_URL . 'css/gallery-style.css', 
        array(), 
        ISMUSEN_GALLERY_VERSION
    );
    
    wp_enqueue_script('ismusen-gallery-script', 
        ISMUSEN_GALLERY_PLUGIN_URL . 'js/gallery-script.js', 
        array('jquery'), 
        ISMUSEN_GALLERY_VERSION, 
        true
    );
    
    // 获取相册数据
    $gallery_data = get_option('ismusen_gallery_data', array(
        'categories' => array(),
        'images' => array()
    ));
    
    // 本地化脚本，传递数据给JS
    wp_localize_script('ismusen-gallery-script', 'ismusenGallery', array(
        'galleryData' => $gallery_data
    ));
}

// 管理界面脚本和样式
function ismusen_gallery_admin_scripts($hook) {
    if ($hook != 'toplevel_page_ismusen-gallery') {
        return;
    }
    
    // 加载管理样式
    wp_enqueue_style('ismusen-gallery-admin-style', 
        ISMUSEN_GALLERY_PLUGIN_URL . 'css/admin-style.css', 
        array(), 
        ISMUSEN_GALLERY_VERSION
    );
    
    // 加载管理脚本
    wp_enqueue_script('ismusen-gallery-admin-script', 
        ISMUSEN_GALLERY_PLUGIN_URL . 'js/admin-script.js', 
        array('jquery'), 
        ISMUSEN_GALLERY_VERSION, 
        true
    );
    
    // 获取相册数据
    $gallery_data = get_option('ismusen_gallery_data', array(
        'categories' => array(),
        'images' => array()
    ));
    
    // 本地化脚本，传递数据给JS
    wp_localize_script('ismusen-gallery-admin-script', 'ismusenGalleryAdmin', array(
        'galleryData' => $gallery_data,
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ismusen_gallery_admin_nonce')
    ));
}

// 处理图片上传
function ismusen_gallery_handle_upload() {
    // 验证nonce
    if (!wp_verify_nonce($_POST['nonce'], 'ismusen_gallery_admin_nonce')) {
        wp_send_json_error('安全验证失败');
    }
    
    if (!current_user_can('upload_files')) {
        wp_send_json_error('权限不足');
    }
    
    if (!empty($_FILES['image'])) {
        $file = $_FILES['image'];
        
        // 检查文件类型
        $allowed_types = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
        if (!in_array($file['type'], $allowed_types)) {
            wp_send_json_error('只允许上传JPEG、PNG和GIF格式的图片');
        }
        
        // 生成唯一文件名
        $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $file_name = uniqid() . '.' . $file_ext;
        $file_path = ISMUSEN_GALLERY_IMAGE_DIR . $file_name;
        
        // 移动文件
        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            // 返回图片URL
            wp_send_json_success(array(
                'url' => ISMUSEN_GALLERY_IMAGE_URL . $file_name,
                'name' => $file['name']
            ));
        } else {
            wp_send_json_error('文件上传失败');
        }
    } else {
        wp_send_json_error('没有接收到文件');
    }
    
    wp_die();
}

// 添加管理菜单
function ismusen_gallery_admin_menu() {
    add_menu_page(
        'Ismusen相册',
        'Ismusen相册',
        'manage_options',
        'ismusen-gallery',
        'ismusen_gallery_admin_page',
        'dashicons-format-gallery',
        25
    );
}

// 管理页面
function ismusen_gallery_admin_page() {
    // 获取相册数据
    $gallery_data = get_option('ismusen_gallery_data', array(
        'categories' => array(),
        'images' => array()
    ));
    
    // 处理表单提交
    if (isset($_POST['save_gallery_data'])) {
        // 验证nonce
        if (!wp_verify_nonce($_POST['_wpnonce'], 'ismusen_gallery_save')) {
            wp_die('安全验证失败');
        }
        
        // 处理分类数据
        $categories = array();
        if (!empty($_POST['category_ids'])) {
            foreach ($_POST['category_ids'] as $index => $id) {
                if (!empty($_POST['category_names'][$index])) {
                    $categories[] = array(
                        'id' => sanitize_text_field($id),
                        'name' => sanitize_text_field($_POST['category_names'][$index])
                    );
                }
            }
        }
        
        // 处理图片数据
        $images = array();
        if (!empty($_POST['image_urls'])) {
            foreach ($_POST['image_urls'] as $index => $url) {
                if (!empty($url)) {
                    $images[] = array(
                        'id' => intval($_POST['image_ids'][$index]),
                        'src' => esc_url_raw($url),
                        'title' => sanitize_text_field($_POST['image_titles'][$index]),
                        'desc' => sanitize_text_field($_POST['image_descs'][$index]),
                        'category' => sanitize_text_field($_POST['image_categories'][$index]),
                        'orientation' => sanitize_text_field($_POST['image_orientations'][$index])
                    );
                }
            }
        }
        
        // 保存数据
        update_option('ismusen_gallery_data', array(
            'categories' => $categories,
            'images' => $images
        ));
        
        echo '<div class="notice notice-success"><p>相册数据已保存</p></div>';
        
        // 重新获取数据
        $gallery_data = get_option('ismusen_gallery_data');
    }
    
    ?>
    <div class="wrap gallery-management">
        <h1>Ismusen相册管理</h1>
        
        <form method="post">
            <?php wp_nonce_field('ismusen_gallery_save'); ?>
            
            <div class="gallery-tabs">
                <div class="gallery-tab active" data-tab="categories">分类管理</div>
                <div class="gallery-tab" data-tab="images">图片管理</div>
            </div>
            
            <div id="categories" class="gallery-tab-content active">
                <h2>分类管理</h2>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="new-category-name">新分类名称</label></th>
                        <td>
                            <input type="text" id="new-category-name" class="regular-text">
                            <button type="button" id="add-category" class="button">添加分类</button>
                            <p class="description">添加新分类后，需要在下方保存设置才能生效</p>
                        </td>
                    </tr>
                </table>
                
                <h3>现有分类</h3>
                <div class="category-list">
                    <?php if (!empty($gallery_data['categories'])) : ?>
                        <?php foreach ($gallery_data['categories'] as $index => $category) : ?>
                            <div class="category-item">
                                <table class="form-table">
                                    <tr>
                                        <th scope="row"><label>分类名称</label></th>
                                        <td>
                                            <input type="text" name="category_names[]" value="<?php echo esc_attr($category['name']); ?>" class="regular-text">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><label>分类ID</label></th>
                                        <td>
                                            <input type="text" name="category_ids[]" value="<?php echo esc_attr($category['id']); ?>" class="regular-text">
                                            <p class="description">分类ID用于短代码筛选，只能包含字母、数字和连字符</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>暂无分类</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div id="images" class="gallery-tab-content">
                <h2>图片管理</h2>
                
                <h3>上传新图片</h3>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="image-upload">选择图片</label></th>
                        <td>
                            <input type="file" id="image-upload" accept="image/*">
                            <button type="button" id="upload-image" class="button">上传图片</button>
                            <p class="description">上传图片到插件目录</p>
                            <div id="upload-progress"></div>
                        </td>
                    </tr>
                </table>
                
                <h3>添加图片信息</h3>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="image-url">图片URL</label></th>
                        <td>
                            <input type="text" id="image-url" class="regular-text">
                            <p class="description">图片URL或上传后自动填充</p>
                            <div id="image-preview"></div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="image-title">图片标题</label></th>
                        <td>
                            <input type="text" id="image-title" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="image-desc">图片描述</label></th>
                        <td>
                            <input type="text" id="image-desc" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="image-orientation">图片方向</label></th>
                        <td>
                            <select id="image-orientation">
                                <option value="landscape">横图</option>
                                <option value="portrait">竖图</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="image-category">分类</label></th>
                        <td>
                            <select id="image-category">
                                <?php if (!empty($gallery_data['categories'])) : ?>
                                    <?php foreach ($gallery_data['categories'] as $category) : ?>
                                        <option value="<?php echo esc_attr($category['id']); ?>"><?php echo esc_html($category['name']); ?></option>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <option value="">请先添加分类</option>
                                <?php endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"></th>
                        <td>
                            <button type="button" id="add-image" class="button button-primary">添加图片</button>
                            <p class="description">添加图片后，需要在下方保存设置才能生效</p>
                        </td>
                    </tr>
                </table>
                
                <!-- 添加图片筛选功能 -->
                <h3>图片筛选</h3>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="filter-category">按分类筛选</label></th>
                        <td>
                            <select id="filter-category">
                                <option value="all">全部图片</option>
                                <?php if (!empty($gallery_data['categories'])) : ?>
                                    <?php foreach ($gallery_data['categories'] as $category) : ?>
                                        <option value="<?php echo esc_attr($category['id']); ?>">
                                            <?php echo esc_html($category['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </td>
                    </tr>
                </table>
                
                <h3>图片缩略图列表</h3>
                <div id="image-grid-preview" class="image-grid">
                    <?php if (!empty($gallery_data['images'])) : ?>
                        <?php foreach ($gallery_data['images'] as $index => $image) : ?>
                            <div class="image-thumbnail" data-id="<?php echo esc_attr($image['id']); ?>" data-category="<?php echo esc_attr($image['category']); ?>">
                                <img src="<?php echo esc_url($image['src']); ?>" alt="<?php echo esc_attr($image['title']); ?>">
                                <div class="image-actions">
                                    <button type="button" class="button edit-image" data-id="<?php echo esc_attr($image['id']); ?>">编辑</button>
                                    <button type="button" class="button delete-image" data-id="<?php echo esc_attr($image['id']); ?>">删除</button>
                                </div>
                                <input type="hidden" name="image_ids[]" value="<?php echo esc_attr($image['id']); ?>">
                                <input type="hidden" name="image_urls[]" value="<?php echo esc_attr($image['src']); ?>">
                                <input type="hidden" name="image_titles[]" value="<?php echo esc_attr($image['title']); ?>">
                                <input type="hidden" name="image_descs[]" value="<?php echo esc_attr($image['desc']); ?>">
                                <input type="hidden" name="image_categories[]" value="<?php echo esc_attr($image['category']); ?>">
                                <input type="hidden" name="image_orientations[]" value="<?php echo esc_attr($image['orientation']); ?>">
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>暂无图片</p>
                    <?php endif; ?>
                </div>
                
                <!-- 图片编辑模态框 -->
                <div id="image-edit-modal" class="modal" style="display: none;">
                    <div class="modal-content">
                        <h3>编辑图片信息</h3>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><label>图片URL</label></th>
                                <td>
                                    <input type="text" id="edit-image-url" class="regular-text" disabled>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label>图片标题</label></th>
                                <td>
                                    <input type="text" id="edit-image-title" class="regular-text">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label>图片描述</label></th>
                                <td>
                                    <input type="text" id="edit-image-desc" class="regular-text">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label>图片方向</label></th>
                                <td>
                                    <select id="edit-image-orientation">
                                        <option value="landscape">横图</option>
                                        <option value="portrait">竖图</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label>分类</label></th>
                                <td>
                                    <select id="edit-image-category">
                                        <?php if (!empty($gallery_data['categories'])) : ?>
                                            <?php foreach ($gallery_data['categories'] as $category) : ?>
                                                <option value="<?php echo esc_attr($category['id']); ?>"><?php echo esc_html($category['name']); ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <div class="modal-actions">
                            <button type="button" id="save-image-changes" class="button button-primary">保存更改</button>
                            <button type="button" id="cancel-image-edit" class="button">取消</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <p class="submit">
                <input type="submit" name="save_gallery_data" class="button button-primary" value="保存设置">
            </p>
        </form>
        
        <h2>使用说明</h2>
        <p>在文章或页面中使用短代码 <code>[ismusen_gallery]</code> 显示相册。</p>
        <p>如需按分类显示，可以使用 <code>[ismusen_gallery category="nature"]</code>，其中 "nature" 是分类ID。</p>
    </div>
    <?php
}

// 短代码处理
function ismusen_gallery_shortcode($atts) {
    $atts = shortcode_atts(array(
        'category' => 'all'
    ), $atts);
    
    // 获取相册数据
    $gallery_data = get_option('ismusen_gallery_data', array(
        'categories' => array(),
        'images' => array()
    ));
    
    ob_start();
    ?>
    <div id="ismusen-gallery-container">
        <div class="album-title">
            <p>记录生活中值得珍藏的时刻，每一张照片都有一个故事。</p>
        </div>

        <div class="album-filters">
            <button class="filter-btn active" data-filter="all">全部</button>
            <?php foreach ($gallery_data['categories'] as $category) : ?>
                <button class="filter-btn" data-filter="<?php echo esc_attr($category['id']); ?>">
                    <?php echo esc_html($category['name']); ?>
                </button>
            <?php endforeach; ?>
        </div>
        
        <div class="album-grid">
            <?php foreach ($gallery_data['images'] as $image) : 
                // 如果指定了分类，只显示该分类的图片
                if ($atts['category'] !== 'all' && $image['category'] !== $atts['category']) {
                    continue;
                }
            ?>
                <div class="album-item <?php echo esc_attr($image['orientation']); ?>" 
                     data-category="<?php echo esc_attr($image['category']); ?>" 
                     data-id="<?php echo esc_attr($image['id']); ?>">
                    <img src="<?php echo esc_url($image['src']); ?>" alt="<?php echo esc_attr($image['title']); ?>">
                    <div class="album-item-overlay">
                        <h3><?php echo esc_html($image['title']); ?></h3>
                        <p><?php echo esc_html($image['desc']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="back-to-home">
            <a href="<?php echo home_url(); ?>" class="home-link">
                ← 返回 <?php echo get_bloginfo('name'); ?> 主页
            </a>
        </div>
    </div>
    
    <!-- 灯箱 -->
    <div class="lightbox">
        <div class="lightbox-content">
            <button class="lightbox-close">×</button>
            <div class="lightbox-nav">
                <button class="lightbox-prev">←</button>
                <button class="lightbox-next">→</button>
            </div>
            <img src="" alt="">
            <p class="lightbox-caption"></p>
        </div>
    </div>
    <?php
    return ob_get_clean();
}