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

    $content_marker = "\n<!-- doro-content:1.7.9 -->\n";

    $aviso = '<p>' . esc_html( sprintf( __( 'Este aviso legal regula el uso del sitio web de %s. Al navegar por la web aceptas las condiciones aquí descritas.', 'doroshopping' ), $site_name ) ) . '</p>'
        . '<h2>' . esc_html__( '1. Datos identificativos', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html__( 'Titular del sitio: completa razón social, CIF/NIF, domicilio social y datos de inscripción registral (si aplica).', 'doroshopping' ) . '</p>'
        . '<ul>'
        . '<li>' . esc_html__( 'Email de contacto: atencionalcliente@doroshopping.com', 'doroshopping' ) . '</li>'
        . '<li>' . esc_html__( 'Sitio web: doroshopping.com y dominios asociados.', 'doroshopping' ) . '</li>'
        . '</ul>'
        . '<h2>' . esc_html__( '2. Objeto', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html__( 'La web ofrece información comercial y la posibilidad de adquirir productos a través de la tienda online. El titular se reserva el derecho de modificar contenidos, precios y disponibilidad sin previo aviso, sin perjuicio de los pedidos ya confirmados.', 'doroshopping' ) . '</p>'
        . '<h2>' . esc_html__( '3. Condiciones de uso', 'doroshopping' ) . '</h2>'
        . '<ul>'
        . '<li>' . esc_html__( 'Debes usar la web de forma lícita y respetuosa con la normativa vigente.', 'doroshopping' ) . '</li>'
        . '<li>' . esc_html__( 'No está permitido alterar, dañar o interferir en el funcionamiento del sitio o de sistemas asociados.', 'doroshopping' ) . '</li>'
        . '<li>' . esc_html__( 'Eres responsable de la veracidad de los datos que facilites en pedidos y registro.', 'doroshopping' ) . '</li>'
        . '</ul>'
        . '<h2>' . esc_html__( '4. Propiedad intelectual', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html__( 'Textos, diseños, logotipos, imágenes y código de la web están protegidos. Queda prohibida su reproducción, distribución o transformación sin autorización, salvo usos permitidos por ley.', 'doroshopping' ) . '</p>'
        . '<h2>' . esc_html__( '5. Responsabilidad', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html__( 'No garantizamos la ausencia total de interrupciones o errores técnicos. No respondemos de daños derivados del uso indebido de la web ni de contenidos de terceros enlazados, sin perjuicio de las obligaciones legales de consumo aplicables a la venta de productos.', 'doroshopping' ) . '</p>'
        . '<h2>' . esc_html__( '6. Legislación aplicable', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html__( 'Este aviso se rige por la legislación española y europea aplicable. Para controversias, serán competentes los juzgados correspondientes conforme a la normativa de consumidores cuando proceda.', 'doroshopping' ) . '</p>'
        . $content_marker;

    $terminos = '<p>' . esc_html( sprintf( __( 'Estas condiciones generales regulan la compra en %s. Al realizar un pedido aceptas estas condiciones junto con la Política de privacidad y, en su caso, la Política de cookies.', 'doroshopping' ), $site_name ) ) . '</p>'
        . '<h2>' . esc_html__( '1. Ámbito y aceptación', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html__( 'Las condiciones se aplican a todos los pedidos realizados a través de la tienda online. Si no estás de acuerdo, no uses el servicio de compra.', 'doroshopping' ) . '</p>'
        . '<h2>' . esc_html__( '2. Productos e información', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html__( 'Las fichas de producto incluyen descripción, precio e información orientativa de envío cuando esté disponible. Las imágenes son ilustrativas. Nos esforzamos por mantener la información actualizada; ante discrepancias relevantes, contacta con soporte.', 'doroshopping' ) . '</p>'
        . '<h2>' . esc_html__( '3. Precios y pagos', 'doroshopping' ) . '</h2>'
        . '<ul>'
        . '<li>' . esc_html__( 'Los precios se muestran en la moneda indicada en la tienda e incluyen impuestos cuando así se indique.', 'doroshopping' ) . '</li>'
        . '<li>' . esc_html__( 'El coste de envío se calcula antes de confirmar el pedido.', 'doroshopping' ) . '</li>'
        . '<li>' . esc_html__( 'El pago se realiza mediante las pasarelas habilitadas en el checkout.', 'doroshopping' ) . '</li>'
        . '</ul>'
        . '<h2>' . esc_html__( '4. Pedidos y contrato', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html__( 'El pedido constituye una oferta de compra. La aceptación se confirma por email y/o cambio de estado del pedido. Nos reservamos el derecho de rechazar pedidos por error manifiesto de precio, falta de stock, sospecha de fraude o datos incompletos.', 'doroshopping' ) . '</p>'
        . '<h2>' . esc_html__( '5. Envíos y entrega', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html__( 'Los plazos de entrega son estimados. El riesgo de pérdida o deterioro se transmite conforme a la normativa aplicable. Debes facilitar una dirección de entrega correcta y accesible.', 'doroshopping' ) . '</p>'
        . '<h2>' . esc_html__( '6. Desistimiento y devoluciones', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html__( 'Si eres consumidor en la UE, dispones del derecho de desistimiento en los términos legales (normalmente 14 días desde la recepción), con las excepciones previstas. Consulta la Política de devoluciones para el procedimiento.', 'doroshopping' ) . '</p>'
        . '<h2>' . esc_html__( '7. Garantía', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html__( 'Los productos gozan de la garantía legal de conformidad. Conserva la factura o confirmación de pedido para gestionar cualquier reclamación.', 'doroshopping' ) . '</p>'
        . '<h2>' . esc_html__( '8. Uso de la cuenta', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html__( 'Eres responsable de custodiar tus credenciales. Notifícanos cualquier uso no autorizado de tu cuenta.', 'doroshopping' ) . '</p>'
        . '<h2>' . esc_html__( '9. Modificaciones', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html__( 'Podemos actualizar estas condiciones. La versión vigente es la publicada en esta página en la fecha de la compra.', 'doroshopping' ) . '</p>'
        . '<h2>' . esc_html__( '10. Contacto', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html__( 'Para dudas contractuales o de pedidos: atencionalcliente@doroshopping.com o el Centro de ayuda.', 'doroshopping' ) . '</p>'
        . $content_marker;

    $cookies = '<p>' . esc_html__( 'Esta Política de cookies explica qué son las cookies, cuáles usamos y cómo puedes gestionarlas.', 'doroshopping' ) . '</p>'
        . '<h2>' . esc_html__( '1. ¿Qué son las cookies?', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html__( 'Son pequeños archivos que el sitio o terceros guardan en tu dispositivo para recordar preferencias, mantener la sesión, analizar el uso o personalizar contenidos.', 'doroshopping' ) . '</p>'
        . '<h2>' . esc_html__( '2. Tipos de cookies que podemos usar', 'doroshopping' ) . '</h2>'
        . '<ul>'
        . '<li>' . esc_html__( 'Técnicas / necesarias: permiten navegar, usar el carrito, el checkout y la seguridad del sitio.', 'doroshopping' ) . '</li>'
        . '<li>' . esc_html__( 'Preferencias: recuerdan idioma, ubicación o moneda cuando aplique.', 'doroshopping' ) . '</li>'
        . '<li>' . esc_html__( 'Analíticas: ayudan a entender el uso de la web de forma agregada.', 'doroshopping' ) . '</li>'
        . '<li>' . esc_html__( 'Marketing: solo si las aceptas y están activadas, para medir campañas.', 'doroshopping' ) . '</li>'
        . '</ul>'
        . '<h2>' . esc_html__( '3. Base legal', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html__( 'Las cookies necesarias se basan en el interés legítimo / ejecución del servicio. El resto requieren tu consentimiento cuando la normativa lo exija.', 'doroshopping' ) . '</p>'
        . '<h2>' . esc_html__( '4. Cómo gestionar las cookies', 'doroshopping' ) . '</h2>'
        . '<ul>'
        . '<li>' . esc_html__( 'Puedes configurar tu navegador para bloquear o eliminar cookies.', 'doroshopping' ) . '</li>'
        . '<li>' . esc_html__( 'Si usamos un banner de consentimiento, podrás aceptar, rechazar o configurar categorías no esenciales.', 'doroshopping' ) . '</li>'
        . '<li>' . esc_html__( 'Bloquear cookies necesarias puede impedir el funcionamiento del carrito o del login.', 'doroshopping' ) . '</li>'
        . '</ul>'
        . '<h2>' . esc_html__( '5. Más información', 'doroshopping' ) . '</h2>'
        . '<p>' . esc_html__( 'Para el tratamiento de datos personales, consulta la Política de privacidad. Contacto: atencionalcliente@doroshopping.com.', 'doroshopping' ) . '</p>'
        . $content_marker;

    return array(
        'nosotros'                  => array(
            'title'    => __( 'Sobre nosotros', 'doroshopping' ),
            'content'  => '',
            'template' => 'page-about.php',
        ),
        'aviso-legal'               => array(
            'title'         => __( 'Aviso legal', 'doroshopping' ),
            'content'       => $aviso,
            'force_refresh' => true,
            'template'      => 'page-legal.php',
        ),
        'politica-de-privacidad'    => array(
            'title'     => __( 'Política de privacidad', 'doroshopping' ),
            'content'   => $privacidad,
            'wc_option' => 'woocommerce_privacy_policy_page_id',
            'template'  => 'page-legal.php',
        ),
        'terminos-y-condiciones'    => array(
            'title'         => __( 'Términos y condiciones', 'doroshopping' ),
            'content'       => $terminos,
            'wc_option'     => 'woocommerce_terms_page_id',
            'force_refresh' => true,
            'template'      => 'page-legal.php',
        ),
        'politica-de-cookies'       => array(
            'title'         => __( 'Política de cookies', 'doroshopping' ),
            'content'       => $cookies,
            'force_refresh' => true,
            'template'      => 'page-legal.php',
        ),
        'politica-de-devoluciones'  => array(
            'title'    => __( 'Política de devoluciones y reembolsos', 'doroshopping' ),
            'content'  => '',
            'template' => 'page-returns.php',
        ),
        'envios'                    => array(
            'title'    => __( 'Envíos', 'doroshopping' ),
            'content'  => '',
            'template' => 'page-shipping.php',
        ),
        'contacto'                  => array(
            'title'    => __( 'Contacto', 'doroshopping' ),
            'content'  => '',
            'template' => 'page-contact.php',
        ),
        'centro-de-ayuda'           => array(
            'title'    => __( 'Centro de ayuda', 'doroshopping' ),
            'content'  => '',
            'template' => 'page-help.php',
        ),
        'preguntas-frecuentes'      => array(
            'title'    => __( 'Preguntas frecuentes', 'doroshopping' ),
            'content'  => '',
            'template' => 'page-faq.php',
        ),
        'ayuda-faq'                 => array(
            'title'    => __( 'Ayuda y preguntas frecuentes', 'doroshopping' ),
            'content'  => '',
            'template' => 'page-faq.php',
        ),
        'cupones'                   => array(
            'title'    => __( 'Cupones', 'doroshopping' ),
            'content'  => '',
            'template' => 'page-coupons.php',
        ),
        'proteccion-del-comprador'  => array(
            'title'    => __( 'Seguridad y protección del comprador', 'doroshopping' ),
            'content'  => '',
            'template' => 'page-buyer-protection.php',
        ),
        'metodos-de-pago'           => array(
            'title'    => __( 'Métodos de pago', 'doroshopping' ),
            'content'  => '',
            'template' => 'page-payments.php',
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
 * Actualiza el contenido si la página sigue con placeholder o marcador antiguo.
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

    $current       = (string) $post->post_content;
    $marker_old    = '<!-- Edita este contenido en Paginas o con Elementor. -->';
    $marker_new    = '<!-- doro-content:1.7.9 -->';
    $force         = ! empty( $data['force_refresh'] );
    $has_new       = false !== strpos( $current, $marker_new );
    $has_old_ph    = false !== strpos( $current, $marker_old );
    $plain_len     = strlen( wp_strip_all_tags( $current ) );

    // Contenido custom largo sin marcadores del tema: no tocar.
    if ( ! $has_new && ! $has_old_ph && $plain_len > 500 && ! $force ) {
        return;
    }
    if ( $force && ! $has_new && ! $has_old_ph && $plain_len > 800 && false === strpos( $current, 'doro-content:' ) ) {
        // Posible contenido manual extenso: no sobrescribir.
        return;
    }
    if ( $has_new ) {
        return;
    }

    $refresh_slugs = array(
        'nosotros',
        'politica-de-privacidad',
        'proteccion-del-comprador',
        'aviso-legal',
        'terminos-y-condiciones',
        'politica-de-cookies',
        'metodos-de-pago',
        'envios',
    );
    $slug = $post->post_name;
    if ( ! $force && ! in_array( $slug, $refresh_slugs, true ) ) {
        return;
    }
    if ( ! $force && ! $has_old_ph && $plain_len > 280 ) {
        // Legacy: solo refrescar si aún es placeholder corto o falta contenido nuevo conocido.
        $known = ( false !== strpos( $current, 'Quiénes somos' ) )
            || ( false !== strpos( $current, 'Responsable del tratamiento' ) )
            || ( false !== strpos( $current, 'Pagos seguros' ) );
        if ( $known ) {
            return;
        }
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
        $need = $need || ! doroshopping_get_page_by_slug( 'cupones' );
        $need = $need || ! doroshopping_get_page_by_slug( 'centro-de-ayuda' );
        $need = $need || ! doroshopping_get_page_by_slug( 'preguntas-frecuentes' );
        // Reasignar plantillas / refrescar legales aunque las páginas ya existan.
        if ( ! $need ) {
            $defs = doroshopping_essential_pages();
            foreach ( array( 'metodos-de-pago', 'envios', 'proteccion-del-comprador', 'politica-de-privacidad', 'aviso-legal', 'terminos-y-condiciones', 'politica-de-cookies' ) as $slug_check ) {
                $p = doroshopping_get_page_by_slug( $slug_check );
                if ( ! $p instanceof WP_Post ) {
                    $need = true;
                    break;
                }
                if ( ! empty( $defs[ $slug_check ]['template'] ) ) {
                    $want = sanitize_file_name( $defs[ $slug_check ]['template'] );
                    if ( (string) get_page_template_slug( $p->ID ) !== $want ) {
                        $need = true;
                        break;
                    }
                }
                if ( ! empty( $defs[ $slug_check ]['force_refresh'] ) && false === strpos( (string) $p->post_content, '<!-- doro-content:1.7.9 -->' ) ) {
                    $need = true;
                    break;
                }
            }
        }
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
        $nonce = isset( $_GET['_doroshopping_notice_nonce'] ) ? sanitize_text_field( wp_unslash( $_GET['_doroshopping_notice_nonce'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        if ( $nonce && wp_verify_nonce( $nonce, 'doroshopping_dismiss_notice' ) ) {
            update_option( 'doroshopping_install_notice_dismissed', DOROSHOPPING_VERSION, false );
        }
        return;
    }

    if ( get_option( 'doroshopping_install_notice_dismissed' ) === DOROSHOPPING_VERSION ) {
        return;
    }

    $dismiss = esc_url(
        add_query_arg(
            array(
                'doroshopping_dismiss_notice' => '1',
                '_doroshopping_notice_nonce'  => wp_create_nonce( 'doroshopping_dismiss_notice' ),
            )
        )
    );
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
