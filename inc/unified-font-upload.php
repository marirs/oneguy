<?php
/**
 * Unified Font Upload Interface for Minimalio Theme
 * Combines Simple and Advanced font upload methods in tabs
 *
 * @package minimalio
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Unified Font Upload Class
 */
class Minimalio_Unified_Font_Upload {
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'add_font_upload_page' ] );
        add_action( 'admin_init', [ $this, 'handle_font_upload' ] );
        add_action( 'admin_init', [ $this, 'handle_advanced_font_upload' ] );
        add_action( 'wp_ajax_minimalio_delete_font', [ $this, 'ajax_delete_font' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_custom_fonts' ] );
    }
    
    /**
     * Add font upload page to admin menu
     */
    public function add_font_upload_page() {
        add_theme_page(
            __( 'Font Upload', 'minimalio' ),
            __( 'Font Upload', 'minimalio' ),
            'edit_theme_options',
            'minimalio-font-upload',
            [ $this, 'render_font_upload_page' ]
        );
    }
    
    /**
     * Render the font upload page with tabs
     */
    public function render_font_upload_page() {
        $active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'simple';
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'Font Upload', 'minimalio' ); ?></h1>
            
            <!-- Tabs Navigation -->
            <nav class="nav-tab-wrapper">
                <a href="?page=minimalio-font-upload&tab=simple" class="nav-tab <?php echo $active_tab === 'simple' ? 'nav-tab-active' : ''; ?>">
                    <?php esc_html_e( 'Simple Upload', 'minimalio' ); ?>
                </a>
                <a href="?page=minimalio-font-upload&tab=advanced" class="nav-tab <?php echo $active_tab === 'advanced' ? 'nav-tab-active' : ''; ?>">
                    <?php esc_html_e( 'Advanced Upload', 'minimalio' ); ?>
                </a>
            </nav>
            
            <div class="tab-content">
                <?php if ( $active_tab === 'simple' ) : ?>
                    <?php $this->render_simple_upload_tab(); ?>
                <?php else : ?>
                    <?php $this->render_advanced_upload_tab(); ?>
                <?php endif; ?>
            </div>
            
            <!-- Uploaded Fonts Section (Common for both tabs) -->
            <div class="card" style="margin-top: 20px;">
                <h2><?php esc_html_e( 'Uploaded Fonts', 'minimalio' ); ?></h2>
                <?php $this->render_uploaded_fonts_table(); ?>
            </div>
        </div>
        
        <style>
        .tab-content {
            background: white;
            border: 1px solid #ccd0d4;
            border-top: none;
            padding: 20px;
            margin-bottom: 20px;
        }
        .font-file-uploader {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .font-variant-select {
            width: 200px;
            min-width: 200px;
        }
        .remove-font-file {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            flex-shrink: 0;
        }
        .remove-font-file:hover {
            background-color: #c82333;
        }
        #font-file-uploaders {
            max-width: 100%;
            overflow-x: auto;
        }
        </style>
        <?php
    }
    
    /**
     * Render simple upload tab
     */
    private function render_simple_upload_tab() {
        ?>
        <div class="card">
            <h2><?php esc_html_e( 'Simple Font Upload', 'minimalio' ); ?></h2>
            <p><?php esc_html_e( 'Upload individual fonts without worrying about variants. Each font will be available with standard weights (Regular, Bold, etc.) in the customizer.', 'minimalio' ); ?></p>
            
            <form method="post" enctype="multipart/form-data" action="">
                <?php wp_nonce_field( 'minimalio_upload_simple_font', 'minimalio_simple_font_nonce' ); ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="simple_font_name"><?php esc_html_e( 'Font Name', 'minimalio' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="simple_font_name" name="simple_font_name" class="regular-text" required>
                            <p class="description"><?php esc_html_e( 'Enter a name for your font (e.g., "My Custom Font")', 'minimalio' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="simple_font_file"><?php esc_html_e( 'Font File', 'minimalio' ); ?></label>
                        </th>
                        <td>
                            <input type="file" id="simple_font_file" name="simple_font_file" accept=".woff,.woff2,.ttf,.otf" required>
                            <p class="description"><?php esc_html_e( 'Upload your font file (WOFF, WOFF2, TTF, or OTF format). This will be used as the Regular (400) weight.', 'minimalio' ); ?></p>
                        </td>
                    </tr>
                </table>
                
                <?php submit_button( __( 'Upload Font', 'minimalio' ), 'primary', 'upload_simple_font' ); ?>
            </form>
        </div>
        <?php
    }
    
    /**
     * Render advanced upload tab
     */
    private function render_advanced_upload_tab() {
        ?>
        <div class="card">
            <h2><?php esc_html_e( 'Advanced Font Upload', 'minimalio' ); ?></h2>
            <p><?php esc_html_e( 'Upload multiple font variants for complete control over different weights and styles.', 'minimalio' ); ?></p>
            
            <form method="post" enctype="multipart/form-data" action="">
                <?php wp_nonce_field( 'minimalio_upload_advanced_font', 'minimalio_advanced_font_nonce' ); ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="advanced_font_name"><?php esc_html_e( 'Font Name', 'minimalio' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="advanced_font_name" name="advanced_font_name" class="regular-text" required>
                            <p class="description"><?php esc_html_e( 'Enter a name for your font (e.g., "My Custom Font")', 'minimalio' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label><?php esc_html_e( 'Font Files', 'minimalio' ); ?></label>
                        </th>
                        <td>
                            <div id="font-file-uploaders">
                                <div class="font-file-uploader">
                                    <select name="font_variants[]" class="font-variant-select">
                                        <option value="regular"><?php esc_html_e( 'Regular (400)', 'minimalio' ); ?></option>
                                        <option value="italic"><?php esc_html_e( 'Italic (400)', 'minimalio' ); ?></option>
                                        <option value="700"><?php esc_html_e( 'Bold (700)', 'minimalio' ); ?></option>
                                        <option value="700italic"><?php esc_html_e( 'Bold Italic (700)', 'minimalio' ); ?></option>
                                        <option value="300"><?php esc_html_e( 'Light (300)', 'minimalio' ); ?></option>
                                        <option value="300italic"><?php esc_html_e( 'Light Italic (300)', 'minimalio' ); ?></option>
                                    </select>
                                    <input type="file" name="font_files[]" accept=".woff,.woff2,.ttf,.otf" required>
                                    <button type="button" class="button remove-font-file"><?php esc_html_e( 'Remove', 'minimalio' ); ?></button>
                                </div>
                            </div>
                            <button type="button" id="add-font-file" class="button"><?php esc_html_e( 'Add Font Variant', 'minimalio' ); ?></button>
                            <p class="description"><?php esc_html_e( 'Upload font files (WOFF, WOFF2, TTF, or OTF format). You can upload multiple variants like regular, bold, italic, etc.', 'minimalio' ); ?></p>
                        </td>
                    </tr>
                </table>
                
                <?php submit_button( __( 'Upload Font', 'minimalio' ), 'primary', 'upload_advanced_font' ); ?>
            </form>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            $('#add-font-file').on('click', function() {
                var uploader = $('.font-file-uploader:first').clone();
                uploader.find('input[type="file"]').val('');
                $('#font-file-uploaders').append(uploader);
            });
            
            $(document).on('click', '.remove-font-file', function() {
                if ($('.font-file-uploader').length > 1) {
                    $(this).closest('.font-file-uploader').remove();
                }
            });
        });
        </script>
        <?php
    }
    
    /**
     * Render uploaded fonts table (shows both simple and advanced fonts)
     */
    private function render_uploaded_fonts_table() {
        $simple_fonts = $this->get_simple_fonts();
        $advanced_fonts = $this->get_advanced_fonts();
        
        if ( empty( $simple_fonts ) && empty( $advanced_fonts ) ) {
            echo '<p>' . esc_html__( 'No custom fonts uploaded yet.', 'minimalio' ) . '</p>';
            return;
        }
        
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr>';
        echo '<th>' . esc_html__( 'Font Name', 'minimalio' ) . '</th>';
        echo '<th>' . esc_html__( 'Type', 'minimalio' ) . '</th>';
        echo '<th>' . esc_html__( 'Variants/Format', 'minimalio' ) . '</th>';
        echo '<th>' . esc_html__( 'Actions', 'minimalio' ) . '</th>';
        echo '</tr></thead>';
        echo '<tbody>';
        
        // Show simple fonts
        foreach ( $simple_fonts as $font_id => $font_data ) {
            echo '<tr>';
            echo '<td><strong>' . esc_html( $font_data['name'] ) . '</strong></td>';
            echo '<td><span class="badge badge-simple">' . esc_html__( 'Simple', 'minimalio' ) . '</span></td>';
            echo '<td>' . esc_html( strtoupper( $font_data['format'] ) ) . '</td>';
            echo '<td>';
            echo '<button type="button" class="button button-small delete-font" data-font-id="' . esc_attr( 'simple_' . $font_id ) . '">' . esc_html__( 'Delete', 'minimalio' ) . '</button>';
            echo '</td>';
            echo '</tr>';
        }
        
        // Show advanced fonts
        foreach ( $advanced_fonts as $font_id => $font_data ) {
            echo '<tr>';
            echo '<td><strong>' . esc_html( $font_data['name'] ) . '</strong></td>';
            echo '<td><span class="badge badge-advanced">' . esc_html__( 'Advanced', 'minimalio' ) . '</span></td>';
            echo '<td>' . esc_html( implode( ', ', array_keys( $font_data['variants'] ) ) ) . '</td>';
            echo '<td>';
            echo '<button type="button" class="button button-small delete-font" data-font-id="' . esc_attr( 'advanced_' . $font_id ) . '">' . esc_html__( 'Delete', 'minimalio' ) . '</button>';
            echo '</td>';
            echo '</tr>';
        }
        
        echo '</tbody></table>';
        
        // Add delete functionality
        ?>
        <script>
        jQuery(document).ready(function($) {
            $('.delete-font').on('click', function() {
                if (confirm('<?php esc_html_e( 'Are you sure you want to delete this font? This action cannot be undone.', 'minimalio' ); ?>')) {
                    var fontId = $(this).data('font-id');
                    var button = $(this);
                    
                    $.post(ajaxurl, {
                        action: 'minimalio_delete_font',
                        font_id: fontId,
                        _ajax_nonce: '<?php echo wp_create_nonce( "minimalio_delete_font" ); ?>'
                    }, function(response) {
                        if (response.success) {
                            button.closest('tr').fadeOut(400, function() {
                                $(this).remove();
                                if ($('.wp-list-table tbody tr').length === 0) {
                                    location.reload();
                                }
                            });
                        } else {
                            alert('<?php esc_html_e( 'Error deleting font. Please try again.', 'minimalio' ); ?>');
                        }
                    });
                }
            });
        });
        </script>
        
        <style>
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-simple {
            background-color: #28a745;
            color: white;
        }
        .badge-advanced {
            background-color: #0073aa;
            color: white;
        }
        </style>
        <?php
    }
    
    /**
     * Handle simple font upload
     */
    public function handle_font_upload() {
        if ( ! isset( $_POST['upload_simple_font'] ) || ! isset( $_POST['minimalio_simple_font_nonce'] ) ) {
            return;
        }
        
        if ( ! wp_verify_nonce( $_POST['minimalio_simple_font_nonce'], 'minimalio_upload_simple_font' ) ) {
            wp_die( __( 'Security check failed.', 'minimalio' ) );
        }
        
        if ( ! current_user_can( 'edit_theme_options' ) ) {
            wp_die( __( 'You do not have sufficient permissions to perform this action.', 'minimalio' ) );
        }
        
        $font_name = sanitize_text_field( $_POST['simple_font_name'] );
        $font_file = isset( $_FILES['simple_font_file'] ) ? $_FILES['simple_font_file'] : [];
        
        if ( empty( $font_name ) || empty( $font_file['name'] ) ) {
            add_settings_error( 'minimalio_fonts', 'font_upload_error', __( 'Please provide a font name and a font file.', 'minimalio' ), 'error' );
            return;
        }
        
        // Create upload directory
        $upload_dir = wp_upload_dir();
        $font_dir = $upload_dir['basedir'] . '/minimalio-fonts/';
        
        if ( ! file_exists( $font_dir ) ) {
            wp_mkdir_p( $font_dir );
        }
        
        $font_id = sanitize_title( $font_name );
        $file_tmp = $font_file['tmp_name'];
        $file_error = $font_file['error'];
        
        if ( $file_error !== UPLOAD_ERR_OK ) {
            add_settings_error( 'minimalio_fonts', 'font_upload_error', __( 'Error uploading font file.', 'minimalio' ), 'error' );
            return;
        }
        
        // Validate file type
        $file_ext = strtolower( pathinfo( $font_file['name'], PATHINFO_EXTENSION ) );
        $allowed_exts = [ 'woff', 'woff2', 'ttf', 'otf' ];
        
        if ( ! in_array( $file_ext, $allowed_exts ) ) {
            add_settings_error( 'minimalio_fonts', 'font_upload_error', __( 'Invalid file type. Please upload WOFF, WOFF2, TTF, or OTF files.', 'minimalio' ), 'error' );
            return;
        }
        
        // Generate unique filename
        $new_filename = $font_id . '.' . $file_ext;
        $upload_path = $font_dir . $new_filename;
        
        // Move uploaded file
        if ( move_uploaded_file( $file_tmp, $upload_path ) ) {
            $font_data = [
                'name' => $font_name,
                'file' => $new_filename,
                'url' => $upload_dir['baseurl'] . '/minimalio-fonts/' . $new_filename,
                'format' => $file_ext
            ];
            
            // Save font data
            $fonts = $this->get_simple_fonts();
            $fonts[$font_id] = $font_data;
            update_option( 'minimalio_simple_custom_fonts', $fonts );
            
            add_settings_error( 'minimalio_fonts', 'font_upload_success', __( 'Font uploaded successfully!', 'minimalio' ), 'success' );
            
            // Redirect to prevent form resubmission
            wp_safe_redirect( admin_url( 'themes.php?page=minimalio-font-upload&tab=simple' ) );
            exit;
        } else {
            add_settings_error( 'minimalio_fonts', 'font_upload_error', __( 'Error saving font file.', 'minimalio' ), 'error' );
        }
    }
    
    /**
     * Handle advanced font upload
     */
    public function handle_advanced_font_upload() {
        if ( ! isset( $_POST['upload_advanced_font'] ) || ! isset( $_POST['minimalio_advanced_font_nonce'] ) ) {
            return;
        }
        
        if ( ! wp_verify_nonce( $_POST['minimalio_advanced_font_nonce'], 'minimalio_upload_advanced_font' ) ) {
            wp_die( __( 'Security check failed.', 'minimalio' ) );
        }
        
        if ( ! current_user_can( 'edit_theme_options' ) ) {
            wp_die( __( 'You do not have sufficient permissions to perform this action.', 'minimalio' ) );
        }
        
        $font_name = sanitize_text_field( $_POST['advanced_font_name'] );
        $font_variants = isset( $_POST['font_variants'] ) ? array_map( 'sanitize_text_field', $_POST['font_variants'] ) : [];
        $font_files = isset( $_FILES['font_files'] ) ? $_FILES['font_files'] : [];
        
        if ( empty( $font_name ) || empty( $font_files['name'][0] ) ) {
            add_settings_error( 'minimalio_fonts', 'font_upload_error', __( 'Please provide a font name and at least one font file.', 'minimalio' ), 'error' );
            return;
        }
        
        // Create upload directory
        $upload_dir = wp_upload_dir();
        $font_dir = $upload_dir['basedir'] . '/minimalio-fonts/';
        
        if ( ! file_exists( $font_dir ) ) {
            wp_mkdir_p( $font_dir );
        }
        
        $font_id = sanitize_title( $font_name );
        $font_data = [
            'name' => $font_name,
            'variants' => []
        ];
        
        // Process each font file
        foreach ( $font_files['name'] as $key => $file_name ) {
            if ( empty( $file_name ) ) {
                continue;
            }
            
            $variant = isset( $font_variants[$key] ) ? $font_variants[$key] : 'regular';
            $file_tmp = $font_files['tmp_name'][$key];
            $file_error = $font_files['error'][$key];
            
            if ( $file_error !== UPLOAD_ERR_OK ) {
                add_settings_error( 'minimalio_fonts', 'font_upload_error', __( 'Error uploading font file.', 'minimalio' ), 'error' );
                continue;
            }
            
            // Validate file type
            $file_ext = strtolower( pathinfo( $file_name, PATHINFO_EXTENSION ) );
            $allowed_exts = [ 'woff', 'woff2', 'ttf', 'otf' ];
            
            if ( ! in_array( $file_ext, $allowed_exts ) ) {
                add_settings_error( 'minimalio_fonts', 'font_upload_error', __( 'Invalid file type. Please upload WOFF, WOFF2, TTF, or OTF files.', 'minimalio' ), 'error' );
                continue;
            }
            
            // Generate unique filename
            $new_filename = $font_id . '-' . $variant . '.' . $file_ext;
            $upload_path = $font_dir . $new_filename;
            
            // Move uploaded file
            if ( move_uploaded_file( $file_tmp, $upload_path ) ) {
                $font_data['variants'][$variant] = [
                    'file' => $new_filename,
                    'url' => $upload_dir['baseurl'] . '/minimalio-fonts/' . $new_filename,
                    'format' => $file_ext
                ];
            } else {
                add_settings_error( 'minimalio_fonts', 'font_upload_error', __( 'Error saving font file.', 'minimalio' ), 'error' );
            }
        }
        
        if ( empty( $font_data['variants'] ) ) {
            add_settings_error( 'minimalio_fonts', 'font_upload_error', __( 'No valid font files were uploaded.', 'minimalio' ), 'error' );
            return;
        }
        
        // Save font data
        $fonts = $this->get_advanced_fonts();
        $fonts[$font_id] = $font_data;
        update_option( 'minimalio_custom_fonts', $fonts );
        
        add_settings_error( 'minimalio_fonts', 'font_upload_success', __( 'Font uploaded successfully!', 'minimalio' ), 'success' );
        
        // Redirect to prevent form resubmission
        wp_safe_redirect( admin_url( 'themes.php?page=minimalio-font-upload&tab=advanced' ) );
        exit;
    }
    
    /**
     * AJAX handler for deleting fonts
     */
    public function ajax_delete_font() {
        check_ajax_referer( 'minimalio_delete_font', '_ajax_nonce' );
        
        if ( ! current_user_can( 'edit_theme_options' ) ) {
            wp_die( __( 'You do not have sufficient permissions to perform this action.', 'minimalio' ) );
        }
        
        $font_id = sanitize_text_field( $_POST['font_id'] );
        
        // Check if it's a simple or advanced font
        if ( strpos( $font_id, 'simple_' ) === 0 ) {
            $font_id = substr( $font_id, 7 ); // Remove 'simple_' prefix
            $fonts = $this->get_simple_fonts();
            $option_name = 'minimalio_simple_custom_fonts';
        } elseif ( strpos( $font_id, 'advanced_' ) === 0 ) {
            $font_id = substr( $font_id, 9 ); // Remove 'advanced_' prefix
            $fonts = $this->get_advanced_fonts();
            $option_name = 'minimalio_custom_fonts';
        } else {
            wp_send_json_error( __( 'Invalid font ID.', 'minimalio' ) );
        }
        
        if ( ! isset( $fonts[$font_id] ) ) {
            wp_send_json_error( __( 'Font not found.', 'minimalio' ) );
        }
        
        // Delete font file(s)
        $upload_dir = wp_upload_dir();
        $font_dir = $upload_dir['basedir'] . '/minimalio-fonts/';
        
        if ( $option_name === 'minimalio_simple_custom_fonts' ) {
            // Delete simple font file
            $file_path = $font_dir . $fonts[$font_id]['file'];
            if ( file_exists( $file_path ) ) {
                unlink( $file_path );
            }
        } else {
            // Delete advanced font files
            foreach ( $fonts[$font_id]['variants'] as $variant ) {
                $file_path = $font_dir . $variant['file'];
                if ( file_exists( $file_path ) ) {
                    unlink( $file_path );
                }
            }
        }
        
        // Remove font from database
        unset( $fonts[$font_id] );
        update_option( $option_name, $fonts );
        
        wp_send_json_success();
    }
    
    /**
     * Get simple uploaded fonts
     */
    public function get_simple_fonts() {
        return get_option( 'minimalio_simple_custom_fonts', [] );
    }
    
    /**
     * Get advanced uploaded fonts
     */
    public function get_advanced_fonts() {
        return get_option( 'minimalio_custom_fonts', [] );
    }
    
    /**
     * Enqueue custom fonts (both simple and advanced)
     */
    public function enqueue_custom_fonts() {
        $simple_fonts = $this->get_simple_fonts();
        $advanced_fonts = $this->get_advanced_fonts();
        
        if ( empty( $simple_fonts ) && empty( $advanced_fonts ) ) {
            return;
        }
        
        $css = '';
        
        // Process simple fonts
        foreach ( $simple_fonts as $font_id => $font_data ) {
            // Generate multiple font-face declarations for common weights
            $font_faces = [
                '400' => 'normal',
                '700' => 'normal',
                '400' => 'italic',
                '700' => 'italic',
            ];
            
            foreach ( $font_faces as $weight => $style ) {
                $font_face = "@font-face {\n";
                $font_face .= "  font-family: '" . esc_js( $font_data['name'] ) . "';\n";
                $font_face .= "  src: url('" . esc_url( $font_data['url'] ) . "') format('" . esc_js( $font_data['format'] ) . "');\n";
                $font_face .= "  font-weight: " . esc_js( $weight ) . ";\n";
                $font_face .= "  font-style: " . esc_js( $style ) . ";\n";
                $font_face .= "  font-display: swap;\n";
                $font_face .= "}\n\n";
                
                $css .= $font_face;
            }
        }
        
        // Process advanced fonts
        foreach ( $advanced_fonts as $font_id => $font_data ) {
            foreach ( $font_data['variants'] as $variant_name => $variant_data ) {
                $font_face = "@font-face {\n";
                $font_face .= "  font-family: '" . esc_js( $font_data['name'] ) . "';\n";
                $font_face .= "  src: url('" . esc_url( $variant_data['url'] ) . "') format('" . esc_js( $variant_data['format'] ) . "');\n";
                $font_face .= "  font-weight: " . esc_js( minimalio_get_font_weight_from_variant( $variant_name ) ) . ";\n";
                $font_face .= "  font-style: " . esc_js( strpos( $variant_name, 'italic' ) !== false ? 'italic' : 'normal' ) . ";\n";
                $font_face .= "  font-display: swap;\n";
                $font_face .= "}\n\n";
                
                $css .= $font_face;
            }
        }
        
        if ( ! empty( $css ) ) {
            wp_register_style( 'minimalio-custom-fonts', false );
            wp_enqueue_style( 'minimalio-custom-fonts' );
            wp_add_inline_style( 'minimalio-custom-fonts', $css );
        }
    }
}

// Initialize the unified font upload class
new Minimalio_Unified_Font_Upload();
