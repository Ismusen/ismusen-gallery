jQuery(document).ready(function($) {
    // 选项卡切换
    $(".gallery-tab").click(function() {
        $(".gallery-tab").removeClass("active");
        $(this).addClass("active");
        $(".gallery-tab-content").removeClass("active");
        $("#" + $(this).data("tab")).addClass("active");
    });
    
    // 图片URL预览
    $("#image-url").on("blur", function() {
        var url = $(this).val();
        if (url) {
            $("#image-preview").html('<img src="' + url + '" class="image-preview">');
        }
    });
    
    // 添加分类
    $("#add-category").click(function() {
        var name = $("#new-category-name").val().trim();
        
        if (name) {
            // 生成默认ID
            var id = name.toLowerCase().replace(/\s+/g, "-");
            
            // 检查是否已存在
            var exists = false;
            $("input[name='category_names[]']").each(function() {
                if ($(this).val().toLowerCase() === name.toLowerCase()) {
                    exists = true;
                    return false;
                }
            });
            
            if (exists) {
                alert("该分类已存在！");
                return;
            }
            
            // 添加到分类列表
            var html = '<div class="category-item">';
            html += '<table class="form-table">';
            html += '<tr><th scope="row"><label>分类名称</label></th>';
            html += '<td><input type="text" name="category_names[]" value="' + name + '" class="regular-text"></td></tr>';
            html += '<tr><th scope="row"><label>分类ID</label></th>';
            html += '<td><input type="text" name="category_ids[]" value="' + id + '" class="regular-text">';
            html += '<p class="description">分类ID用于短代码筛选，只能包含字母、数字和连字符</p></td></tr>';
            html += '</table></div>';
            
            $(".category-list").append(html);
            
            // 添加到分类下拉菜单
            $("#image-category, #edit-image-category, #filter-category").append(new Option(name, id));
            
            // 清空输入
            $("#new-category-name").val("");
            
            alert("分类已添加，请点击保存设置按钮保存更改");
        } else {
            alert("请输入分类名称");
        }
    });
    
    // 上传图片
    $("#upload-image").click(function() {
        var fileInput = document.getElementById("image-upload");
        var file = fileInput.files[0];
        
        if (!file) {
            alert("请选择要上传的图片");
            return;
        }
        
        // 显示上传进度
        $("#upload-progress").show().html("上传中...");
        
        var formData = new FormData();
        formData.append("action", "ismusen_gallery_upload");
        formData.append("nonce", ismusenGalleryAdmin.nonce);
        formData.append("image", file);
        
        $.ajax({
            url: ismusenGalleryAdmin.ajaxurl,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $("#image-url").val(response.data.url);
                    $("#image-preview").html('<img src="' + response.data.url + '" class="image-preview">');
                    $("#upload-progress").html("上传成功: " + response.data.name);
                } else {
                    $("#upload-progress").html("上传失败: " + response.data);
                }
            },
            error: function() {
                $("#upload-progress").html("上传失败: 网络错误");
            }
        });
    });
    
    // 媒体库选择图片
    $("#media-library-button").click(function() {
        var frame = wp.media({
            title: '选择图片',
            multiple: false,
            library: {
                type: 'image'
            },
            button: {
                text: '使用此图片'
            }
        });
        
        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            $("#image-url").val(attachment.url);
            $("#image-preview").html('<img src="' + attachment.url + '" class="image-preview">');
        });
        
        frame.open();
    });
    
    // 添加图片
    $("#add-image").click(function() {
        var url = $("#image-url").val().trim();
        var title = $("#image-title").val().trim();
        var desc = $("#image-desc").val().trim();
        var orientation = $("#image-orientation").val();
        var category = $("#image-category").val();
        
        if (url && title) {
            // 生成新ID
            var newId = 1;
            $("input[name='image_ids[]']").each(function() {
                var id = parseInt($(this).val());
                if (id >= newId) newId = id + 1;
            });
            
            // 添加到图片网格
            var html = '<div class="image-thumbnail" data-id="' + newId + '" data-category="' + category + '">';
            html += '<img src="' + url + '" alt="' + title + '">';
            html += '<div class="image-actions">';
            html += '<button type="button" class="button edit-image" data-id="' + newId + '">编辑</button>';
            html += '<button type="button" class="button delete-image" data-id="' + newId + '">删除</button>';
            html += '</div>';
            html += '<input type="hidden" name="image_ids[]" value="' + newId + '">';
            html += '<input type="hidden" name="image_urls[]" value="' + url + '">';
            html += '<input type="hidden" name="image_titles[]" value="' + title + '">';
            html += '<input type="hidden" name="image_descs[]" value="' + desc + '">';
            html += '<input type="hidden" name="image_categories[]" value="' + category + '">';
            html += '<input type="hidden" name="image_orientations[]" value="' + orientation + '">';
            html += '</div>';
            
            $("#image-grid-preview").append(html);
            
            // 清空表单
            $("#image-url, #image-title, #image-desc").val("");
            $("#image-preview").empty();
            
            alert("图片已添加，请点击保存设置按钮保存更改");
        } else {
            alert("请填写图片URL和标题");
        }
    });
    
    // 编辑图片
    $(document).on("click", ".edit-image", function() {
        var id = $(this).data("id");
        var thumbnail = $(this).closest(".image-thumbnail");
        
        // 填充模态框表单
        $("#edit-image-url").val(thumbnail.find("input[name='image_urls[]']").val());
        $("#edit-image-title").val(thumbnail.find("input[name='image_titles[]']").val());
        $("#edit-image-desc").val(thumbnail.find("input[name='image_descs[]']").val());
        $("#edit-image-orientation").val(thumbnail.find("input[name='image_orientations[]']").val());
        $("#edit-image-category").val(thumbnail.find("input[name='image_categories[]']").val());
        
        // 存储当前编辑的图片ID
        $("#image-edit-modal").data("edit-id", id);
        
        // 显示模态框
        $("#image-edit-modal").show();
    });
    
    // 保存图片更改
    $("#save-image-changes").click(function() {
        var id = $("#image-edit-modal").data("edit-id");
        var thumbnail = $(".image-thumbnail[data-id='" + id + "']");
        var newCategory = $("#edit-image-category").val();
        
        // 更新隐藏字段的值
        thumbnail.find("input[name='image_titles[]']").val($("#edit-image-title").val());
        thumbnail.find("input[name='image_descs[]']").val($("#edit-image-desc").val());
        thumbnail.find("input[name='image_orientations[]']").val($("#edit-image-orientation").val());
        thumbnail.find("input[name='image_categories[]']").val(newCategory);
        
        // 更新缩略图显示
        thumbnail.find("img").attr("alt", $("#edit-image-title").val());
        
        // 更新分类数据属性
        thumbnail.attr("data-category", newCategory);
        
        // 关闭模态框
        $("#image-edit-modal").hide();
        
        alert("图片信息已更新，请点击保存设置按钮保存更改");
    });
    
    // 取消编辑
    $("#cancel-image-edit").click(function() {
        $("#image-edit-modal").hide();
    });
    
    // 删除图片
    $(document).on("click", ".delete-image", function() {
        if (confirm("确定要删除这张图片吗？")) {
            $(this).closest(".image-thumbnail").remove();
        }
    });
    
    // 点击模态框外部关闭
    $(document).click(function(e) {
        if ($(e.target).hasClass("modal")) {
            $(".modal").hide();
        }
    });
    
    // 添加分类筛选功能
    $("#filter-category").change(function() {
        var category = $(this).val();
        
        if (category === "all") {
            $(".image-thumbnail").show();
        } else {
            $(".image-thumbnail").each(function() {
                var imgCategory = $(this).find("input[name='image_categories[]']").val();
                if (imgCategory === category) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    });
});