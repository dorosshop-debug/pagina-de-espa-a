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
    $site_name   = get_bloginfo( 'name' ) ? get_bloginfo( 'name' ) : 'Doroshopping';

    $nosotros = '<h2>' . esc_html__( 'Quiénes somos', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html( sprintf(
            /* translators: %s: site name */
            __( '%s es una tienda online orientada al mercado español y europeo, con catálogo de electrónica, hogar, deporte y productos de consumo. Operamos con envíos internacionales y atención al cliente en español para que comprar online sea simple y seguro.', 'doroshopping' ),
            $site_name
        ) ) . '</p>'
        . '<h2>' . esc_html__( 'Nuestro alcance', 'doroshopping' ) . '</h2>'
        . '<ul>'
        . '<li>' . esc_html__( 'Catálogo amplio con proveedores europeos y logística dropshipping.', 'doroshopping' ) . '</li>'
        . '<li>' . esc_html__( 'Envíos a España y otros países de la UE, con seguimiento del pedido.', 'doroshopping' ) . '</li>'
        . '<li>' . esc_html__( 'Pagos seguros y protección del comprador en cada transacción.', 'doroshopping' ) . '</li>'
        . '<li>' . esc_html__( 'Soporte en español para dudas de pedidos, envíos y devoluciones.', 'doroshopping' ) . '</li>'
        . '</ul>'
        . '<h2>' . esc_html__( 'Compromiso', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html__( 'Trabajamos para ofrecer precios competitivos, información clara del producto y un proceso de compra transparente: desde el carrito hasta la entrega. Si necesitas ayuda, visita Contacto o el Centro de ayuda.', 'doroshopping' ) . '</p>'
        . $placeholder;

    $privacidad = '<p>' . esc_html__( 'Esta Política de Privacidad describe cómo tratamos tus datos personales cuando usas nuestra tienda online, de conformidad con el RGPD (UE) 2016/679 y la LOPDGDD.', 'doroshopping' ) . '</p>'
        . '<h2>' . esc_html__( '1. Responsable del tratamiento', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html( sprintf( __( 'El responsable es el titular de %s. Los datos de contacto corporativos y domicilio social se detallan en el Aviso legal.', 'doroshopping' ), $site_name ) ) . '</p>'
        . '<h2>' . esc_html__( '2. Datos que tratamos', 'doroshopping' ) . '</h2>'
        . '<ul>'
        . '<li>' . esc_html__( 'Identificación y contacto: nombre, apellidos, email, teléfono, dirección de envío/facturación.', 'doroshopping' ) . '</li>'
        . '<li>' . esc_html__( 'Datos de cuenta y pedidos: historial de compra, preferencias e incidencias.', 'doroshopping' ) . '</li>'
        . '<li>' . esc_html__( 'Datos técnicos: IP, cookies y métricas de navegación (ver Política de cookies).', 'doroshopping' ) . '</li>'
        . '<li>' . esc_html__( 'Datos de pago: gestionados por pasarelas seguras; no almacenamos el número completo de tarjeta.', 'doroshopping' ) . '</li>'
        . '</ul>'
        . '<h2>' . esc_html__( '3. Finalidades y base legal', 'doroshopping' ) . '</h2>'
        . '<ul>'
        . '<li>' . esc_html__( 'Gestionar pedidos y atención al cliente (ejecución del contrato).', 'doroshopping' ) . '</li>'
        . '<li>' . esc_html__( 'Cumplir obligaciones legales (fiscales y de consumo).', 'doroshopping' ) . '</li>'
        . '<li>' . esc_html__( 'Mejorar la web y la seguridad (interés legítimo).', 'doroshopping' ) . '</li>'
        . '<li>' . esc_html__( 'Envío de novedades comerciales solo con tu consentimiento, cuando aplique.', 'doroshopping' ) . '</li>'
        . '</ul>'
        . '<h2>' . esc_html__( '4. Destinatarios', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html__( 'Podemos compartir datos con proveedores de logística, pago, hosting y herramientas necesarias para prestar el servicio, bajo acuerdos de confidencialidad. No vendemos tus datos a terceros.', 'doroshopping' ) . '</p>'
        . '<h2>' . esc_html__( '5. Conservación', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html__( 'Conservamos los datos el tiempo necesario para la relación comercial y los plazos legales aplicables.', 'doroshopping' ) . '</p>'
        . '<h2>' . esc_html__( '6. Tus derechos', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html__( 'Puedes solicitar acceso, rectificación, supresión, oposición, limitación y portabilidad escribiendo a la dirección de contacto de la tienda. También puedes reclamar ante la AEPD (www.aepd.es).', 'doroshopping' ) . '</p>'
        . $placeholder;

    $seguridad = '<p>' . esc_html( sprintf( __( 'En %s protegemos tu compra con medidas técnicas y de proceso para que pagues y recibas con tranquilidad.', 'doroshopping' ), $site_name ) ) . '</p>'
        . '<h2>' . esc_html__( 'Pagos seguros', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html__( 'Las transacciones se procesan mediante pasarelas de pago con cifrado SSL/TLS. No almacenamos los datos completos de tu tarjeta en nuestros servidores.', 'doroshopping' ) . '</p>'
        . '<h2>' . esc_html__( 'Protección del comprador', 'doroshopping' ) . '</h2>'
        . '<ul>'
        . '<li>' . esc_html__( 'Confirmación de pedido y seguimiento del envío.', 'doroshopping' ) . '</li>'
        . '<li>' . esc_html__( 'Soporte ante incidencias de entrega o producto.', 'doroshopping' ) . '</li>'
        . '<li>' . esc_html__( 'Derecho de desistimiento según la normativa de consumo de la UE (consulta la Política de devoluciones).', 'doroshopping' ) . '</li>'
        . '</ul>'
        . '<h2>' . esc_html__( 'Privacidad y datos', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html__( 'Tratamos tus datos conforme a la Política de privacidad. Usa siempre la web por HTTPS y no compartas tus credenciales.', 'doroshopping' ) . '</p>'
        . '<h2>' . esc_html__( 'Consejos prácticos', 'doroshopping' ) . '</h2>'
        . '<ul>'
        . '<li>' . esc_html__( 'Revisa la dirección de entrega antes de confirmar el pedido.', 'doroshopping' ) . '</li>'
        . '<li>' . esc_html__( 'Guarda el email de confirmación y el número de pedido.', 'doroshopping' ) . '</li>'
        . '<li>' . esc_html__( 'Contacta con nosotros si detectas un cargo no reconocido.', 'doroshopping' ) . '</li>'
        . '</ul>'
        . $placeholder;

    return array(
        'nosotros'                  => array(
            'title'   => __( 'Sobre nosotros', 'doroshopping' ),
            'content' => $nosotros,
        ),
        'aviso-legal'               => array(
            'title'   => __( 'Aviso legal', 'doroshopping' ),
            'content' => '<p>' . __( 'Datos identificativos del titular del sitio web, CIF/NIF, domicilio social y datos de contacto. Completa esta página con la información legal de tu empresa.', 'doroshopping' ) . '</p>' . $placeholder,
        ),
        'politica-de-privacidad'    => array(
            'title'     => __( 'Política de privacidad', 'doroshopping' ),
            'content'   => $privacidad,
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
            'title'   => __( 'Seguridad y protección del comprador', 'doroshopping' ),
            'content' => $seguridad,
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
        'inicio'                    => array(
            'title'   => __( 'Inicio', 'doroshopping' ),
            'content' => '<!-- DoroTheme front-page: el contenido lo renderiza front-page.php (hero, categorías, ofertas). Edita con Elementor solo si quieres sustituir la home del tema. -->',
        ),
        'tienda'                    => array(
            'title'     => __( 'Tienda', 'doroshopping' ),
            'content'   => '',
            'wc_option' => 'woocommerce_shop_page_id',
        ),
        'carrito'                   => array(
            'title'     => __( 'Carrito', 'doroshopping' ),
            'content'   => '[woocommerce_cart]',
            'wc_option' => 'woocommerce_cart_page_id',
        ),
        'finalizar-compra'          => array(
            'title'     => __( 'Finalizar compra', 'doroshopping' ),
            'content'   => '[woocommerce_checkout]',
            'wc_option' => 'woocommerce_checkout_page_id',
        ),
        'mi-cuenta'                 => array(
            'title'     => __( 'Mi cuenta', 'doroshopping' ),
            'content'   => '[woocommerce_my_account]',
            'wc_option' => 'woocommerce_myaccount_page_id',
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
            doroshopping_maybe_refresh_page_content( $existing->ID, $data );
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

    doroshopping_ensure_front_page();
    doroshopping_ensure_woocommerce_shop_page();
    if ( function_exists( 'doroshopping_ensure_classic_cart_checkout_pages' ) ) {
        doroshopping_ensure_classic_cart_checkout_pages( true );
    }
}
add_action( 'after_switch_theme', 'doroshopping_create_essential_pages' );

/**
 * Asegura página Inicio y la asigna como portada si no hay otra.
 *
 * @return void
 */
function doroshopping_ensure_front_page() {
    $inicio = doroshopping_get_page_by_slug( 'inicio' );
    if ( ! $inicio instanceof WP_Post ) {
        return;
    }

    $current_front = (int) get_option( 'page_on_front', 0 );
    $show_on_front = (string) get_option( 'show_on_front', 'posts' );

    // Si no hay portada estática, o la portada apunta a una página inexistente.
    $front_ok = ( 'page' === $show_on_front && $current_front > 0 && get_post( $current_front ) );
    if ( $front_ok ) {
        return;
    }

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', (int) $inicio->ID );

    // Página de blog opcional: no forzar si no existe.
}

/**
 * Asegura página Tienda y la opción WooCommerce shop.
 *
 * @return void
 */
function doroshopping_ensure_woocommerce_shop_page() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }

    $shop_id = (int) get_option( 'woocommerce_shop_page_id', 0 );
    if ( $shop_id > 0 && get_post( $shop_id ) ) {
        return;
    }

    $tienda = doroshopping_get_page_by_slug( 'tienda' );
    if ( ! $tienda instanceof WP_Post ) {
        $tienda = doroshopping_get_page_by_slug( 'shop' );
    }
    if ( ! $tienda instanceof WP_Post ) {
        return;
    }

    update_option( 'woocommerce_shop_page_id', (int) $tienda->ID );
    if ( function_exists( 'wc_delete_product_transients' ) ) {
        wc_delete_product_transients();
    }
    flush_rewrite_rules( false );
}

/**
 * Regenerar permalinks al activar el tema (páginas nuevas / endpoints WC).
 *
 * @return void
 */
function doroshopping_flush_rewrites_on_switch() {
    flush_rewrite_rules( false );
}
add_action( 'after_switch_theme', 'doroshopping_flush_rewrites_on_switch', 99 );

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

    $option  = $data['wc_option'];
    $current = (int) get_option( $option, 0 );
    // Reasignar si está vacío o apunta a una página borrada.
    if ( $current > 0 && get_post( $current ) ) {
        return;
    }

    update_option( $option, (int) $page_id );
}

/**
 * Actualiza el contenido si la página sigue con el placeholder corto del tema.
 *
 * @param int   $page_id ID.
 * @param array $data    Definición.
 * @return void
 */
function doroshopping_maybe_refresh_page_content( $page_id, $data ) {
    if ( empty( $data['content'] ) ) {
        return;
    }
    $post = get_post( $page_id );
    if ( ! $post instanceof WP_Post ) {
        return;
    }
    $current = (string) $post->post_content;
    $marker  = '<!-- Edita este contenido en Paginas o con Elementor. -->';
    // Solo refrescar páginas cortas / aún no editadas a fondo.
    if ( false === strpos( $current, $marker ) && strlen( wp_strip_all_tags( $current ) ) > 280 ) {
        return;
    }
    if ( false === strpos( $current, $marker ) && strlen( wp_strip_all_tags( $current ) ) > 120 && false === strpos( $current, 'Quiénes somos' ) && false === strpos( $current, 'RGPD' ) && false === strpos( $current, 'Pagos seguros' ) ) {
        // Contenido custom sin marker: no tocar.
        if ( strlen( wp_strip_all_tags( $current ) ) > 200 ) {
            return;
        }
    }

    $refresh_slugs = array( 'nosotros', 'politica-de-privacidad', 'proteccion-del-comprador' );
    $slug          = $post->post_name;
    if ( ! in_array( $slug, $refresh_slugs, true ) ) {
        return;
    }

    // Evitar reescribir si ya tiene el contenido nuevo.
    if ( false !== strpos( $current, 'Quiénes somos' ) || false !== strpos( $current, 'Responsable del tratamiento' ) || false !== strpos( $current, 'Pagos seguros' ) ) {
        return;
    }

    wp_update_post(
        array(
            'ID'           => (int) $page_id,
            'post_content' => $data['content'],
            'post_title'   => isset( $data['title'] ) ? $data['title'] : $post->post_title,
        )
    );
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
        doroshopping_ensure_front_page();
        doroshopping_ensure_woocommerce_shop_page();
        if ( function_exists( 'doroshopping_ensure_classic_cart_checkout_pages' ) ) {
            doroshopping_ensure_classic_cart_checkout_pages( false );
        }
        $need = ! doroshopping_get_page_by_slug( 'tienda' )
            && ! doroshopping_get_page_by_slug( 'shop' );
        $need = $need || ( ! doroshopping_get_page_by_slug( 'carrito' ) && ! doroshopping_get_page_by_slug( 'cart' ) );
        $need = $need || ( ! doroshopping_get_page_by_slug( 'finalizar-compra' ) && ! doroshopping_get_page_by_slug( 'checkout' ) );
        if ( $need ) {
            doroshopping_create_essential_pages();
        }
        return;
    }
    doroshopping_create_essential_pages();
}
add_action( 'admin_init', 'doroshopping_maybe_create_essential_pages_admin' );

/**
 * Aviso de instalación tras activar el tema.
 *
 * @return void
 */
function doroshopping_install_admin_notice() {
    if ( ! current_user_can( 'switch_themes' ) ) {
        return;
    }

    if ( isset( $_GET['doroshopping_dismiss_notice'] ) && '1' === $_GET['doroshopping_dismiss_notice'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        update_option( 'doroshopping_install_notice_dismissed', DOROSHOPPING_VERSION, false );
        return;
    }

    if ( get_option( 'doroshopping_install_notice_dismissed' ) === DOROSHOPPING_VERSION ) {
        return;
    }

    $dismiss = esc_url( add_query_arg( 'doroshopping_dismiss_notice', '1' ) );
    $customizer = esc_url( admin_url( 'customize.php' ) );
    $wc_ok      = class_exists( 'WooCommerce' );

    echo '<div class="notice notice-success is-dismissible"><p><strong>DoroTheme ' . esc_html( DOROSHOPPING_VERSION ) . '</strong> — ';
    if ( ! $wc_ok ) {
        echo esc_html__( 'Instala y activa WooCommerce. Al activar el tema se crean páginas legales, lista de deseos y se prepara Carrito/Checkout clásico.', 'doroshopping' );
    } else {
        $checkout_ok = function_exists( 'doroshopping_get_checkout_url' ) && doroshopping_get_checkout_url();
        $cart_ok     = function_exists( 'doroshopping_get_cart_url' ) && doroshopping_get_cart_url();
        if ( ! $checkout_ok || ! $cart_ok ) {
            echo esc_html__( 'Faltan páginas WooCommerce. Entra a WooCommerce → Ajustes → Avanzado y asigna Carrito / Finalizar compra / Mi cuenta, o vuelve a Activar el tema DoroTheme.', 'doroshopping' );
        } else {
            echo esc_html__( 'Listo para doroshopping.com. Revisa: 1) SSL activo, 2) Carrito/Checkout shortcodes, 3) menús, 4) Personalizar logos, 5) Polylang/YayCurrency si los usas, 6) registro de clientes en WooCommerce.', 'doroshopping' );
        }
        echo ' <a href="' . $customizer . '">' . esc_html__( 'Abrir Personalizar', 'doroshopping' ) . '</a>.';
    }
    echo ' <a href="' . $dismiss . '">' . esc_html__( 'Ocultar aviso', 'doroshopping' ) . '</a>.</p></div>';
}
add_action( 'admin_notices', 'doroshopping_install_admin_notice' );
