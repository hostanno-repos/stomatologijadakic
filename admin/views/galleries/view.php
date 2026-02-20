<?php
/**
 * Gallery View - Manage Images
 * 
 * @package    DakicCMS
 * @subpackage Admin
 */

// Prevent direct access
if (!defined('ADMIN_PATH')) {
    die('Direct access not allowed');
}

$error = getFlash('error');
$success = getFlash('success');
?>

<div class="gallery-view-page">
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="margin: 0; color: #343a40; font-size: 1.75rem; font-weight: 600;">
                <?php echo escape($gallery['title']); ?>
            </h1>
            <a href="<?php echo ADMIN_URL; ?>/galleries" style="color: #74788d; text-decoration: none; font-size: 0.875rem; margin-top: 0.5rem; display: inline-block;">
                ← Nazad na galerije
            </a>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="<?php echo ADMIN_URL; ?>/galleries/edit/<?php echo $gallery['id']; ?>" class="btn btn-primary">
                Izmeni galeriju
            </a>
        </div>
    </div>
    
    <?php if ($error): ?>
        <div class="alert alert-error">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>
    
    <!-- Gallery Info -->
    <div class="gallery-info" style="background: white; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef; margin-bottom: 1.5rem;">
        <?php if (!empty($gallery['description'])): ?>
            <p style="color: #495057; margin: 0 0 0.5rem 0;"><?php echo nl2br(escape($gallery['description'])); ?></p>
        <?php endif; ?>
        <div style="display: flex; gap: 1rem; color: #74788d; font-size: 0.875rem;">
            <span>Status: <strong><?php 
                $statusTranslations = [
                    'active' => 'Aktivan',
                    'inactive' => 'Neaktivan'
                ];
                echo escape($statusTranslations[$gallery['status']] ?? $gallery['status']); 
            ?></strong></span>
            <span>Slika: <strong><?php echo count($images); ?></strong></span>
        </div>
    </div>
    
    <!-- Upload Images Section -->
    <div class="upload-section" style="background: white; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef; margin-bottom: 1.5rem;">
        <h3 style="margin: 0 0 1rem 0; color: #343a40; font-size: 1.125rem; font-weight: 600;">Otpremi slike i video</h3>
        <form id="uploadForm" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1rem;">
            <input type="hidden" name="csrf_token" value="<?php echo escape($csrf_token); ?>">
            <div>
                <input type="file" 
                       id="images" 
                       name="images[]" 
                       multiple 
                       accept="image/jpeg,image/png,image/gif,image/webp,video/mp4,video/webm,video/ogg,video/quicktime"
                       style="width: 100%; padding: 0.625rem; border: 1px solid #e9ecef; border-radius: 0.375rem; font-size: 0.875rem;">
                <small style="display: block; margin-top: 0.25rem; color: #74788d; font-size: 0.75rem;">
                    Izaberite više slika ili video fajlova (JPEG, PNG, GIF, WebP - Maksimum 5MB po slici; MP4, WebM, OGG, MOV - Maksimum 50MB po videu)
                </small>
            </div>
            <button type="submit" class="btn btn-submit" style="align-self: flex-start;">
                Otpremi slike
            </button>
        </form>
        <div id="uploadStatus" style="margin-top: 1rem; display: none;"></div>
    </div>
    
    <!-- Images Grid -->
    <div class="images-section">
        <h3 style="margin: 0 0 1.5rem 0; color: #343a40; font-size: 1.125rem; font-weight: 600;">
            Slike i video (<?php echo count($images); ?>)
        </h3>
        
        <?php if (empty($images)): ?>
            <div class="empty-state" style="background: white; padding: 3rem; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef; text-align: center;">
                <p style="color: #74788d; margin: 0;">Još nema slika ili video fajlova u ovoj galeriji. Otpremite neke fajlove iznad.</p>
            </div>
        <?php else: ?>
            <div class="images-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem;">
                <?php foreach ($images as $image): ?>
                    <?php 
                    $isVideo = strpos($image['mime_type'] ?? '', 'video/') === 0;
                    $mediaUrl = ADMIN_URL . '/' . ltrim($image['file_path'], '/');
                    ?>
                    <div class="image-card" data-image-id="<?php echo $image['id']; ?>" style="background: white; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: 1px solid #e9ecef; overflow: hidden; transition: all 0.3s ease;">
                        <div class="image-card-image" style="width: 100%; height: 200px; background: #f8f9fa; position: relative; overflow: hidden;">
                            <?php if ($isVideo): ?>
                                <video style="width: 100%; height: 100%; object-fit: cover;" muted>
                                    <source src="<?php echo $mediaUrl; ?>" type="<?php echo escape($image['mime_type']); ?>">
                                </video>
                                <div style="position: absolute; top: 0.5rem; right: 0.5rem; background: rgba(0,0,0,0.7); color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem;">
                                    <i class="fas fa-video"></i> Video
                                </div>
                            <?php else: ?>
                                <img src="<?php echo $mediaUrl; ?>" 
                                     alt="<?php echo escape($image['alt_text'] ?? $image['title'] ?? ''); ?>" 
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            <?php endif; ?>
                            <div class="image-card-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); opacity: 0; transition: opacity 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                <a href="<?php echo $mediaUrl; ?>" 
                                   target="_blank" 
                                   style="padding: 0.5rem 1rem; background: white; color: #495057; text-decoration: none; border-radius: 0.25rem; font-size: 0.875rem;">
                                    Pregled
                                </a>
                                <a href="#" 
                                   class="delete-image-btn"
                                   data-image-id="<?php echo $image['id']; ?>"
                                   data-token="<?php echo generateCsrfToken(); ?>"
                                   style="padding: 0.5rem 1rem; background: #f46a6a; color: white; text-decoration: none; border-radius: 0.25rem; font-size: 0.875rem; cursor: pointer;">
                                    Obriši
                                </a>
                            </div>
                        </div>
                        <div class="image-card-content" style="padding: 1rem;">
                            <p style="margin: 0; color: #495057; font-size: 0.875rem; font-weight: 500; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <?php echo escape($image['title'] ?? $image['original_filename'] ?? 'Bez naslova'); ?>
                            </p>
                            <?php if (!$isVideo && $image['width'] && $image['height']): ?>
                                <p style="margin: 0.25rem 0 0 0; color: #74788d; font-size: 0.75rem;">
                                    <?php echo $image['width']; ?> × <?php echo $image['height']; ?>
                                </p>
                            <?php elseif ($isVideo): ?>
                                <p style="margin: 0.25rem 0 0 0; color: #74788d; font-size: 0.75rem;">
                                    <i class="fas fa-video"></i> Video
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadForm = document.getElementById('uploadForm');
    const uploadStatus = document.getElementById('uploadStatus');
    
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Otpremanje...';
            uploadStatus.style.display = 'block';
            uploadStatus.innerHTML = '<div class="alert alert-info" style="background: #e7f3ff; color: #0066cc; padding: 0.875rem; border-radius: 0.375rem; border: 1px solid #b3d9ff;">Otpremanje fajlova...</div>';
            
            fetch('<?php echo ADMIN_URL; ?>/galleries/upload-images/<?php echo $gallery['id']; ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    uploadStatus.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
                    uploadForm.reset();
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    uploadStatus.innerHTML = '<div class="alert alert-error">' + (data.message || 'Otpremanje fajlova nije uspelo') + '</div>';
                    if (data.errors && data.errors.length > 0) {
                        uploadStatus.innerHTML += '<ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;"><li>' + data.errors.join('</li><li>') + '</li></ul>';
                    }
                }
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            })
            .catch(error => {
                uploadStatus.innerHTML = '<div class="alert alert-error">Došlo je do greške tokom otpremanja fajlova.</div>';
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });
    }
    
    // Image card hover effects
    const imageCards = document.querySelectorAll('.image-card');
    imageCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.querySelector('.image-card-overlay').style.opacity = '1';
        });
        card.addEventListener('mouseleave', function() {
            this.querySelector('.image-card-overlay').style.opacity = '0';
        });
    });
    
    // Handle image deletion
    const deleteButtons = document.querySelectorAll('.delete-image-btn');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (!confirm('Are you sure you want to delete this image?')) {
                return;
            }
            
            const imageId = this.getAttribute('data-image-id');
            const token = this.getAttribute('data-token');
            const imageCard = this.closest('.image-card');
            const originalText = this.textContent;
            
            // Disable button and show loading state
            this.disabled = true;
            this.textContent = 'Brisanje...';
            this.style.opacity = '0.6';
            
            fetch('<?php echo ADMIN_URL; ?>/galleries/delete-image/' + imageId + '?token=' + token, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Refresh the page to show updated image list
                    location.reload();
                } else {
                    alert(data.message || 'Brisanje slike nije uspelo');
                    this.disabled = false;
                    this.textContent = originalText;
                    this.style.opacity = '1';
                }
            })
            .catch(error => {
                alert('Došlo je do greške tokom brisanja slike');
                this.disabled = false;
                this.textContent = originalText;
                this.style.opacity = '1';
            });
        });
    });
});
</script>

<style>
.image-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
}

@media (max-width: 768px) {
    .images-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)) !important;
        gap: 1rem !important;
    }
}
</style>
