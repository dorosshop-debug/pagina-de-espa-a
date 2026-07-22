<?php
/**
 * Páginas esenciales (legales, ayuda, marca) con slugs fijos.
 *
 * Se crean al activar el tema (o una vez en admin si faltan).
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Definición de páginas del sitio.
 *
 * @return array<string, array{title: string, content: string, wc_option?: string}>
 */
function doroshopping_essential_pages() {
    $placeholder = "\n\n<!-- Edita este contenido en Paginas o con Elementor. -->\n";

    return array(
        'nosotros'                  => array(
            'title'   => __( 'Sobre nosotros', 'doroshopping' ),
            'content' => '<p>' . __( 'Doroshopping es tu tienda online de confianza. Aquí encontrarás información sobre quiénes somos, nuestra misión y nuestro compromiso con el cliente.', 'doroshopping' ) . '</p>' . $placeholder,
        ),
        'aviso-legal'               => array(
            'title'   => __( 'Aviso legal', 'doroshopping' ),
            'content' => '<p>' . __( 'Datos identificativos del titular del sitio web, CIF/NIF, domicilio social y datos de contacto. Completa esta página con la información legal de tu empresa.', 'doroshopping' ) . '</p>' . $placeholder,
        ),
        'politica-de-privacidad'    => array(
            'title'     => __( 'Política de privacidad', 'doroshopping' ),
            'content'   => '<p>' . __( 'Información sobre el tratamiento de datos personales conforme al RGPD: responsable, finalidades, legitimación, destinatarios, derechos del usuario y conservación.', 'doroshopping' ) . '</p>' . $placeholder,
            'wc_option' => 'woocommerce_privacy_policy_page_id',
        ),
        'terminos-y-condiciones'    => array(
            'title'     => __( 'Términos y condiciones', 'doroshopping' ),
            'content'   => '<p>' . __( 'Condiciones generales de uso y de contratación de la tienda: aceptación, pedidos, precios, pagos, propiedad intelectual y legislación aplicable.', 'doroshopping' ) . '</p>' . $placeholder,
            'wc_option' => 'woocommerce_terms_page_id',
        ),
        'politica-de-cookies'       => array(
            'title'   => __( 'Política de cookies', 'doroshopping' ),
            'content' => '<p>' . __( 'Qué cookies utilizamos, con qué finalidad y cómo puedes gestionar tus preferencias de consentimiento.', 'doroshopping' ) . '</p>' . $placeholder,
        ),
        'politica-de-devoluciones'  => array(
            'title'   => __( 'Política de devoluciones y reembolsos', 'doroshopping' ),
            'content' => '<p>' . __( 'Plazos, condiciones y proceso para devoluciones, cambios y reembolsos. Derecho de desistimiento (14 días en la UE) y excepciones.', 'doroshopping' ) . '</p>' . $placeholder,
        ),
        'envios'                    => array(
            'title'   => __( 'Envíos', 'doroshopping' ),
            'content' => '<p>' . __( 'Zonas de envío, plazos estimados, costes, seguimiento del pedido y posibles gastos de aduana.', 'doroshopping' ) . '</p>' . $placeholder,
        ),
        'contacto'                  => array(
            'title'   => __( 'Contacto', 'doroshopping' ),
            'content' => '<p>' . __( '¿Necesitas ayuda? Escríbenos y te responderemos lo antes posible. Añade aquí el formulario de contacto, email y horarios de atención.', 'doroshopping' ) . '</p>' . $placeholder,
        ),
        'ayuda-faq'                 => array(
            'title'   => __( 'Ayuda y preguntas frecuentes', 'doroshopping' ),
            'content' => '<p>' . __( 'Respuestas a las dudas más habituales sobre pedidos, pagos, envíos, devoluciones y tu cuenta.', 'doroshopping' ) . '</p>' . $placeholder,
        ),
        'proteccion-del-comprador'  => array(
            'title'   => __( 'Protección del comprador', 'doroshopping' ),
            'content' => '<p>' . __( 'Compromisos de Doroshopping con la seguridad de tu compra: garantías, resolución de incidencias y protección de pagos.', 'doroshopping' ) . '</p>' . $placeholder,
        ),
        'metodos-de-pago'           => array(
            'title'   => __( 'Métodos de pago', 'doroshopping' ),
            'content' => '<p>' . __( 'Formas de pago aceptadas, seguridad de las transacciones y consejos para comprar con tranquilidad.', 'doroshopping' ) . '</p>' . $placeholder,
        ),
        'lista-de-deseos'           => array(
            'title'    => __( 'Lista de deseos', 'doroshopping' ),
            'content'  => '',
            'template' => 'page-wishlist.php',
        ),
    );
}

/**
 * Obtener página publicada por slug.
 *
 * @param string $slug Slug.
 * @return WP_Post|null
 */
function doroshopping_get_page_by_slug( $slug ) {
    $slug = sanitize_title( $slug );
    if ( '' === $slug ) {
        return null;
    }

    $pages = get_posts(
        array(
            'name'           => $slug,
            'post_type'      => 'page',
            'post_status'    => 'publish',
            'posts_per_page' => 1,
            'no_found_rows'  => true,
        )
    );

    return ! empty( $pages[0] ) && $pages[0] instanceof WP_Post ? $pages[0] : null;
}

/**
 * URL de una página esencial por slug (o '#' si aún no existe).
 *
 * @param string $slug Slug.
 * @return string
 */
function doroshopping_get_page_url( $slug ) {
    $slug = sanitize_title( $slug );
    if ( '' === $slug ) {
        return '#';
    }

    $page = doroshopping_get_page_by_slug( $slug );
    if ( $page instanceof WP_Post ) {
        return get_permalink( $page );
    }

    return home_url( '/' . $slug . '/' );
}

/**
 * Crear páginas esenciales si no existen.
 *
 * @return void
 */
function doroshopping_create_essential_pages() {
    if ( ! current_user_can( 'publish_pages' ) && ! doing_action( 'after_switch_theme' ) ) {
        return;
    }

    $created = false;

    foreach ( doroshopping_essential_pages() as $slug => $data ) {
        $existing = doroshopping_get_page_by_slug( $slug );
        if ( $existing instanceof WP_Post ) {
            doroshopping_maybe_assign_wc_page( $existing->ID, $data );
            doroshopping_maybe_assign_page_template( $existing->ID, $data );
            continue;
        }

        $page_id = wp_insert_post(
            array(
                'post_title'   => $data['title'],
                'post_name'    => $slug,
                'post_content' => isset( $data['content'] ) ? $data['content'] : '',
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_author'  => get_current_user_id() ? get_current_user_id() : 1,
            ),
            true
        );

        if ( is_wp_error( $page_id ) || ! $page_id ) {
            continue;
        }

        $created = true;
        doroshopping_maybe_assign_wc_page( (int) $page_id, $data );
        doroshopping_maybe_assign_page_template( (int) $page_id, $data );
    }

    if ( $created || ! get_option( 'doroshopping_essential_pages_ready' ) ) {
        update_option( 'doroshopping_essential_pages_ready', DOROSHOPPING_VERSION, false );
    }
}
add_action( 'after_switch_theme', 'doroshopping_create_essential_pages' );

/**
 * Asignar página a opción WooCommerce si está vacía.
 *
 * @param int   $page_id ID.
 * @param array $data    Definición.
 * @return void
 */
function doroshopping_maybe_assign_wc_page( $page_id, $data ) {
    if ( empty( $data['wc_option'] ) || ! class_exists( 'WooCommerce' ) ) {
        return;
    }

    $option = $data['wc_option'];
    $current = (int) get_option( $option, 0 );
    if ( $current > 0 ) {
        return;
    }

    update_option( $option, (int) $page_id );
}

/**
 * Asignar plantilla de página del tema si corresponde.
 *
 * @param int   $page_id ID.
 * @param array $data    Definición.
 * @return void
 */
function doroshopping_maybe_assign_page_template( $page_id, $data ) {
    if ( empty( $data['template'] ) ) {
        return;
    }

    $template = sanitize_file_name( $data['template'] );
    $current  = (string) get_page_template_slug( $page_id );
    if ( $current === $template ) {
        return;
    }

    update_post_meta( (int) $page_id, '_wp_page_template', $template );
}

/**
 * Una sola pasada en admin si el tema ya estaba activo sin páginas.
 *
 * @return void
 */
function doroshopping_maybe_create_essential_pages_admin() {
    if ( ! is_admin() || ! current_user_can( 'publish_pages' ) ) {
        return;
    }
    if ( get_option( 'doroshopping_essential_pages_ready' ) === DOROSHOPPING_VERSION ) {
        return;
    }
    doroshopping_create_essential_pages();
}
add_action( 'admin_init', 'doroshopping_maybe_create_essential_pages_admin' );
