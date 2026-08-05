<?php
/**
 * Traducciones UI embebidas (chrome: header, cuenta, footer).
 * Se usan si no hay valor propio en Personalizar para ese idioma.
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Packs de traducción por idioma (sin español: es la clave base).
 *
 * @return array<string, array<string, string>>
 */
function doroshopping_i18n_builtin_ui_packs() {
	static $packs = null;
	if ( null !== $packs ) {
		return $packs;
	}

	$header_account_footer = array(
		// Header.
		'doroshopping_ui_search_placeholder',
		'doroshopping_ui_search_all',
		'doroshopping_ui_search_empty',
		'doroshopping_ui_search_loading',
		'doroshopping_ui_all_categories',
		'doroshopping_ui_nav_shop',
		'doroshopping_ui_nav_offers',
		'doroshopping_ui_nav_contact',
		'doroshopping_ui_shipping_label',
		'doroshopping_ui_cart_label',
		'doroshopping_ui_greeting_guest',
		'doroshopping_ui_greeting_user',
		'doroshopping_ui_login_label',
		'doroshopping_ui_mega_view_all',
		'doroshopping_ui_mega_view_category',
		// Account.
		'doroshopping_ui_account_go',
		'doroshopping_ui_account_login',
		'doroshopping_ui_account_track',
		'doroshopping_ui_account_orders',
		'doroshopping_ui_account_coupons',
		'doroshopping_ui_account_support',
		'doroshopping_ui_account_wishlist',
		'doroshopping_ui_account_settings',
		'doroshopping_ui_account_profile',
		'doroshopping_ui_account_payments',
		'doroshopping_ui_account_help',
		'doroshopping_ui_account_faq',
		'doroshopping_ui_account_returns',
		'doroshopping_ui_account_privacy',
		'doroshopping_ui_account_logout',
		// Footer.
		'doroshopping_ui_footer_stores',
		'doroshopping_ui_footer_customer',
		'doroshopping_ui_footer_about',
		'doroshopping_ui_footer_privacy',
		'doroshopping_ui_footer_help',
		'doroshopping_ui_footer_faq',
		'doroshopping_ui_footer_contact',
		'doroshopping_ui_footer_guide',
		'doroshopping_ui_footer_payment',
		'doroshopping_ui_footer_shipping',
		'doroshopping_ui_footer_coupons',
		'doroshopping_ui_footer_create_account',
		'doroshopping_ui_footer_buyer',
		'doroshopping_ui_footer_payments',
		'doroshopping_ui_footer_newsletter',
		'doroshopping_ui_footer_email_ph',
		'doroshopping_ui_footer_subscribe',
		'doroshopping_ui_footer_follow',
		'doroshopping_ui_footer_rights',
		'doroshopping_ui_footer_returns',
		'doroshopping_ui_footer_legal_privacy',
		'doroshopping_ui_footer_terms',
		'doroshopping_ui_footer_legal_notice',
		'doroshopping_ui_footer_cookies',
	);

	$en = array(
		'doroshopping_ui_search_placeholder'   => 'Search products',
		'doroshopping_ui_search_all'           => 'See all results',
		'doroshopping_ui_search_empty'         => 'No products found.',
		'doroshopping_ui_search_loading'       => 'Searching...',
		'doroshopping_ui_all_categories'       => 'All categories',
		'doroshopping_ui_nav_shop'             => 'Shop',
		'doroshopping_ui_nav_offers'           => 'Offers',
		'doroshopping_ui_nav_contact'          => 'Contact',
		'doroshopping_ui_shipping_label'       => 'Shipping',
		'doroshopping_ui_cart_label'           => 'Cart',
		'doroshopping_ui_greeting_guest'       => 'Welcome',
		'doroshopping_ui_greeting_user'        => 'Hello',
		'doroshopping_ui_login_label'          => 'Sign in',
		'doroshopping_ui_mega_view_all'        => 'View all',
		'doroshopping_ui_mega_view_category'   => 'View category',
		'doroshopping_ui_account_go'           => 'Go to My account',
		'doroshopping_ui_account_login'        => 'Sign in to your account',
		'doroshopping_ui_account_track'        => 'Track shipment',
		'doroshopping_ui_account_orders'       => 'My orders',
		'doroshopping_ui_account_coupons'      => 'My coupons',
		'doroshopping_ui_account_support'      => 'Help & Support Center',
		'doroshopping_ui_account_wishlist'     => 'Wishlist',
		'doroshopping_ui_account_settings'     => 'Settings',
		'doroshopping_ui_account_profile'      => 'My profile',
		'doroshopping_ui_account_payments'     => 'Payment methods',
		'doroshopping_ui_account_help'         => 'Help center',
		'doroshopping_ui_account_faq'          => "FAQ - Frequently asked questions",
		'doroshopping_ui_account_returns'      => 'Returns and refunds policy',
		'doroshopping_ui_account_privacy'      => 'Personal data protection policy',
		'doroshopping_ui_account_logout'       => 'Log out',
		'doroshopping_ui_footer_stores'        => 'Our stores',
		'doroshopping_ui_footer_customer'      => 'Customer service',
		'doroshopping_ui_footer_about'         => 'About us',
		'doroshopping_ui_footer_privacy'       => 'Privacy policy',
		'doroshopping_ui_footer_help'          => 'Help center',
		'doroshopping_ui_footer_faq'           => "FAQ's",
		'doroshopping_ui_footer_contact'       => 'Contact',
		'doroshopping_ui_footer_guide'         => 'Shopping guide',
		'doroshopping_ui_footer_payment'       => 'Payment',
		'doroshopping_ui_footer_shipping'      => 'Shipping',
		'doroshopping_ui_footer_coupons'       => 'Coupons',
		'doroshopping_ui_footer_create_account'=> 'Create an account',
		'doroshopping_ui_footer_buyer'         => 'Buyer protection',
		'doroshopping_ui_footer_payments'      => 'Payment methods',
		'doroshopping_ui_footer_newsletter'    => 'Sign up and get unique updates.',
		'doroshopping_ui_footer_email_ph'      => 'Email address',
		'doroshopping_ui_footer_subscribe'     => 'Subscribe',
		'doroshopping_ui_footer_follow'        => 'Follow us',
		'doroshopping_ui_footer_rights'        => 'All Rights Reserved',
		'doroshopping_ui_footer_returns'       => 'Returns',
		'doroshopping_ui_footer_legal_privacy' => 'Privacy',
		'doroshopping_ui_footer_terms'         => 'Terms',
		'doroshopping_ui_footer_legal_notice'  => 'Legal notice',
		'doroshopping_ui_footer_cookies'       => 'Cookies',
	);

	$de = array(
		'doroshopping_ui_search_placeholder'   => 'Produkte suchen',
		'doroshopping_ui_search_all'           => 'Alle Ergebnisse anzeigen',
		'doroshopping_ui_search_empty'         => 'Keine Produkte gefunden.',
		'doroshopping_ui_search_loading'       => 'Suche...',
		'doroshopping_ui_all_categories'       => 'Alle Kategorien',
		'doroshopping_ui_nav_shop'             => 'Shop',
		'doroshopping_ui_nav_offers'           => 'Angebote',
		'doroshopping_ui_nav_contact'          => 'Kontakt',
		'doroshopping_ui_shipping_label'       => 'Versand',
		'doroshopping_ui_cart_label'           => 'Warenkorb',
		'doroshopping_ui_greeting_guest'       => 'Willkommen',
		'doroshopping_ui_greeting_user'        => 'Hallo',
		'doroshopping_ui_login_label'          => 'Anmelden',
		'doroshopping_ui_mega_view_all'        => 'Alles ansehen',
		'doroshopping_ui_mega_view_category'   => 'Kategorie ansehen',
		'doroshopping_ui_account_go'           => 'Zum Kundenkonto',
		'doroshopping_ui_account_login'        => 'In Ihr Konto einloggen',
		'doroshopping_ui_account_track'        => 'Sendung verfolgen',
		'doroshopping_ui_account_orders'       => 'Meine Bestellungen',
		'doroshopping_ui_account_coupons'      => 'Meine Gutscheine',
		'doroshopping_ui_account_support'      => 'Hilfe & Support',
		'doroshopping_ui_account_wishlist'     => 'Wunschliste',
		'doroshopping_ui_account_settings'     => 'Einstellungen',
		'doroshopping_ui_account_profile'      => 'Mein Profil',
		'doroshopping_ui_account_payments'     => 'Zahlungsmethoden',
		'doroshopping_ui_account_help'         => 'Hilfezentrum',
		'doroshopping_ui_account_faq'          => 'FAQ - Häufig gestellte Fragen',
		'doroshopping_ui_account_returns'      => 'Rückgabe- und Erstattungsrichtlinie',
		'doroshopping_ui_account_privacy'      => 'Datenschutzrichtlinie',
		'doroshopping_ui_account_logout'       => 'Abmelden',
		'doroshopping_ui_footer_stores'        => 'Unsere Shops',
		'doroshopping_ui_footer_customer'      => 'Kundenservice',
		'doroshopping_ui_footer_about'         => 'Über uns',
		'doroshopping_ui_footer_privacy'       => 'Datenschutz',
		'doroshopping_ui_footer_help'          => 'Hilfezentrum',
		'doroshopping_ui_footer_faq'           => "FAQ's",
		'doroshopping_ui_footer_contact'       => 'Kontakt',
		'doroshopping_ui_footer_guide'         => 'Einkaufsratgeber',
		'doroshopping_ui_footer_payment'       => 'Zahlung',
		'doroshopping_ui_footer_shipping'      => 'Versand',
		'doroshopping_ui_footer_coupons'       => 'Gutscheine',
		'doroshopping_ui_footer_create_account'=> 'Konto erstellen',
		'doroshopping_ui_footer_buyer'         => 'Käuferschutz',
		'doroshopping_ui_footer_payments'      => 'Zahlungsmittel',
		'doroshopping_ui_footer_newsletter'    => 'Registrieren und exklusive Neuigkeiten erhalten.',
		'doroshopping_ui_footer_email_ph'      => 'E-Mail-Adresse',
		'doroshopping_ui_footer_subscribe'     => 'Abonnieren',
		'doroshopping_ui_footer_follow'        => 'Folgen Sie uns',
		'doroshopping_ui_footer_rights'        => 'All Rights Reserved',
		'doroshopping_ui_footer_returns'       => 'Rücksendungen',
		'doroshopping_ui_footer_legal_privacy' => 'Datenschutz',
		'doroshopping_ui_footer_terms'         => 'AGB',
		'doroshopping_ui_footer_legal_notice'  => 'Impressum',
		'doroshopping_ui_footer_cookies'       => 'Cookies',
	);

	$fr = array(
		'doroshopping_ui_search_placeholder'   => 'Rechercher des produits',
		'doroshopping_ui_search_all'           => 'Voir tous les résultats',
		'doroshopping_ui_search_empty'         => 'Aucun produit trouvé.',
		'doroshopping_ui_search_loading'       => 'Recherche...',
		'doroshopping_ui_all_categories'       => 'Toutes les catégories',
		'doroshopping_ui_nav_shop'             => 'Boutique',
		'doroshopping_ui_nav_offers'           => 'Offres',
		'doroshopping_ui_nav_contact'          => 'Contact',
		'doroshopping_ui_shipping_label'       => 'Livraison',
		'doroshopping_ui_cart_label'           => 'Panier',
		'doroshopping_ui_greeting_guest'       => 'Bienvenue',
		'doroshopping_ui_greeting_user'        => 'Bonjour',
		'doroshopping_ui_login_label'          => 'Connexion',
		'doroshopping_ui_mega_view_all'        => 'Tout voir',
		'doroshopping_ui_mega_view_category'   => 'Voir la catégorie',
		'doroshopping_ui_account_go'           => 'Aller à Mon compte',
		'doroshopping_ui_account_login'        => 'Accéder à votre compte',
		'doroshopping_ui_account_track'        => 'Suivre l’envoi',
		'doroshopping_ui_account_orders'       => 'Mes commandes',
		'doroshopping_ui_account_coupons'      => 'Mes coupons',
		'doroshopping_ui_account_support'      => 'Centre d’aide & support',
		'doroshopping_ui_account_wishlist'     => 'Liste de souhaits',
		'doroshopping_ui_account_settings'     => 'Paramètres',
		'doroshopping_ui_account_profile'      => 'Mon profil',
		'doroshopping_ui_account_payments'     => 'Moyens de paiement',
		'doroshopping_ui_account_help'         => 'Centre d’aide',
		'doroshopping_ui_account_faq'          => 'FAQ - Questions fréquentes',
		'doroshopping_ui_account_returns'      => 'Politique de retours et remboursements',
		'doroshopping_ui_account_privacy'      => 'Politique de protection des données',
		'doroshopping_ui_account_logout'       => 'Se déconnecter',
		'doroshopping_ui_footer_stores'        => 'Nos boutiques',
		'doroshopping_ui_footer_customer'      => 'Service client',
		'doroshopping_ui_footer_about'         => 'À propos',
		'doroshopping_ui_footer_privacy'       => 'Politiques de confidentialité',
		'doroshopping_ui_footer_help'          => 'Centre d’aide',
		'doroshopping_ui_footer_faq'           => "FAQ's",
		'doroshopping_ui_footer_contact'       => 'Contact',
		'doroshopping_ui_footer_guide'         => 'Guide d’achat',
		'doroshopping_ui_footer_payment'       => 'Paiement',
		'doroshopping_ui_footer_shipping'      => 'Livraison',
		'doroshopping_ui_footer_coupons'       => 'Coupons',
		'doroshopping_ui_footer_create_account'=> 'Créer un compte',
		'doroshopping_ui_footer_buyer'         => 'Protection de l’acheteur',
		'doroshopping_ui_footer_payments'      => 'Moyens de paiement',
		'doroshopping_ui_footer_newsletter'    => 'Inscrivez-vous et recevez des nouveautés exclusives.',
		'doroshopping_ui_footer_email_ph'      => 'Adresse e-mail',
		'doroshopping_ui_footer_subscribe'     => 'S’abonner',
		'doroshopping_ui_footer_follow'        => 'Suivez-nous',
		'doroshopping_ui_footer_rights'        => 'All Rights Reserved',
		'doroshopping_ui_footer_returns'       => 'Retours',
		'doroshopping_ui_footer_legal_privacy' => 'Confidentialité',
		'doroshopping_ui_footer_terms'         => 'Conditions',
		'doroshopping_ui_footer_legal_notice'  => 'Mentions légales',
		'doroshopping_ui_footer_cookies'       => 'Cookies',
	);

	$it = array(
		'doroshopping_ui_search_placeholder'   => 'Cerca prodotti',
		'doroshopping_ui_search_all'           => 'Vedi tutti i risultati',
		'doroshopping_ui_search_empty'         => 'Nessun prodotto trovato.',
		'doroshopping_ui_search_loading'       => 'Ricerca...',
		'doroshopping_ui_all_categories'       => 'Tutte le categorie',
		'doroshopping_ui_nav_shop'             => 'Negozio',
		'doroshopping_ui_nav_offers'           => 'Offerte',
		'doroshopping_ui_nav_contact'          => 'Contatto',
		'doroshopping_ui_shipping_label'       => 'Spedizione',
		'doroshopping_ui_cart_label'           => 'Carrello',
		'doroshopping_ui_greeting_guest'       => 'Benvenuto',
		'doroshopping_ui_greeting_user'        => 'Ciao',
		'doroshopping_ui_login_label'          => 'Accedi',
		'doroshopping_ui_mega_view_all'        => 'Vedi tutto',
		'doroshopping_ui_mega_view_category'   => 'Vedi categoria',
		'doroshopping_ui_account_go'           => 'Vai al Mio account',
		'doroshopping_ui_account_login'        => 'Accedi al tuo account',
		'doroshopping_ui_account_track'        => 'Traccia spedizione',
		'doroshopping_ui_account_orders'       => 'I miei ordini',
		'doroshopping_ui_account_coupons'      => 'I miei coupon',
		'doroshopping_ui_account_support'      => 'Centro assistenza e supporto',
		'doroshopping_ui_account_wishlist'     => 'Lista dei desideri',
		'doroshopping_ui_account_settings'     => 'Impostazioni',
		'doroshopping_ui_account_profile'      => 'Il mio profilo',
		'doroshopping_ui_account_payments'     => 'Metodi di pagamento',
		'doroshopping_ui_account_help'         => 'Centro assistenza',
		'doroshopping_ui_account_faq'          => 'FAQ - Domande frequenti',
		'doroshopping_ui_account_returns'      => 'Politica di resi e rimborsi',
		'doroshopping_ui_account_privacy'      => 'Politica di protezione dei dati personali',
		'doroshopping_ui_account_logout'       => 'Esci',
		'doroshopping_ui_footer_stores'        => 'I nostri negozi',
		'doroshopping_ui_footer_customer'      => 'Assistenza clienti',
		'doroshopping_ui_footer_about'         => 'Chi siamo',
		'doroshopping_ui_footer_privacy'       => 'Politiche sulla privacy',
		'doroshopping_ui_footer_help'          => 'Centro assistenza',
		'doroshopping_ui_footer_faq'           => "FAQ's",
		'doroshopping_ui_footer_contact'       => 'Contatto',
		'doroshopping_ui_footer_guide'         => 'Guida all’acquisto',
		'doroshopping_ui_footer_payment'       => 'Pagamento',
		'doroshopping_ui_footer_shipping'      => 'Spedizione',
		'doroshopping_ui_footer_coupons'       => 'Coupon',
		'doroshopping_ui_footer_create_account'=> 'Crea un account',
		'doroshopping_ui_footer_buyer'         => 'Protezione acquirente',
		'doroshopping_ui_footer_payments'      => 'Metodi di pagamento',
		'doroshopping_ui_footer_newsletter'    => 'Registrati e ricevi novità esclusive.',
		'doroshopping_ui_footer_email_ph'      => 'Indirizzo e-mail',
		'doroshopping_ui_footer_subscribe'     => 'Iscriviti',
		'doroshopping_ui_footer_follow'        => 'Seguici',
		'doroshopping_ui_footer_rights'        => 'All Rights Reserved',
		'doroshopping_ui_footer_returns'       => 'Resi',
		'doroshopping_ui_footer_legal_privacy' => 'Privacy',
		'doroshopping_ui_footer_terms'         => 'Termini',
		'doroshopping_ui_footer_legal_notice'  => 'Note legali',
		'doroshopping_ui_footer_cookies'       => 'Cookie',
	);

	$pt = array(
		'doroshopping_ui_search_placeholder'   => 'Pesquisar produtos',
		'doroshopping_ui_search_all'           => 'Ver todos os resultados',
		'doroshopping_ui_search_empty'         => 'Nenhum produto encontrado.',
		'doroshopping_ui_search_loading'       => 'A pesquisar...',
		'doroshopping_ui_all_categories'       => 'Todas as categorias',
		'doroshopping_ui_nav_shop'             => 'Loja',
		'doroshopping_ui_nav_offers'           => 'Ofertas',
		'doroshopping_ui_nav_contact'          => 'Contacto',
		'doroshopping_ui_shipping_label'       => 'Envio',
		'doroshopping_ui_cart_label'           => 'Carrinho',
		'doroshopping_ui_greeting_guest'       => 'Bem-vindo',
		'doroshopping_ui_greeting_user'        => 'Olá',
		'doroshopping_ui_login_label'          => 'Entrar',
		'doroshopping_ui_mega_view_all'        => 'Ver tudo',
		'doroshopping_ui_mega_view_category'   => 'Ver categoria',
		'doroshopping_ui_account_go'           => 'Ir para A minha conta',
		'doroshopping_ui_account_login'        => 'Aceder à sua conta',
		'doroshopping_ui_account_track'        => 'Rastrear envio',
		'doroshopping_ui_account_orders'       => 'As minhas encomendas',
		'doroshopping_ui_account_coupons'      => 'Os meus cupões',
		'doroshopping_ui_account_support'      => 'Centro de Ajuda e Suporte',
		'doroshopping_ui_account_wishlist'     => 'Lista de desejos',
		'doroshopping_ui_account_settings'     => 'Definições',
		'doroshopping_ui_account_profile'      => 'O meu perfil',
		'doroshopping_ui_account_payments'     => 'Métodos de pagamento',
		'doroshopping_ui_account_help'         => 'Centro de ajuda',
		'doroshopping_ui_account_faq'          => 'FAQ - Perguntas frequentes',
		'doroshopping_ui_account_returns'      => 'Política de devoluções e reembolsos',
		'doroshopping_ui_account_privacy'      => 'Política de proteção de dados pessoais',
		'doroshopping_ui_account_logout'       => 'Terminar sessão',
		'doroshopping_ui_footer_stores'        => 'As nossas lojas',
		'doroshopping_ui_footer_customer'      => 'Apoio ao cliente',
		'doroshopping_ui_footer_about'         => 'Sobre nós',
		'doroshopping_ui_footer_privacy'       => 'Políticas de privacidade',
		'doroshopping_ui_footer_help'          => 'Centro de ajuda',
		'doroshopping_ui_footer_faq'           => "FAQ's",
		'doroshopping_ui_footer_contact'       => 'Contacto',
		'doroshopping_ui_footer_guide'         => 'Guia de compra',
		'doroshopping_ui_footer_payment'       => 'Pagamento',
		'doroshopping_ui_footer_shipping'      => 'Envio',
		'doroshopping_ui_footer_coupons'       => 'Cupões',
		'doroshopping_ui_footer_create_account'=> 'Criar uma conta',
		'doroshopping_ui_footer_buyer'         => 'Proteção do comprador',
		'doroshopping_ui_footer_payments'      => 'Meios de pagamento',
		'doroshopping_ui_footer_newsletter'    => 'Registe-se e receba novidades exclusivas.',
		'doroshopping_ui_footer_email_ph'      => 'Endereço de e-mail',
		'doroshopping_ui_footer_subscribe'     => 'Subscrever',
		'doroshopping_ui_footer_follow'        => 'Siga-nos',
		'doroshopping_ui_footer_rights'        => 'All Rights Reserved',
		'doroshopping_ui_footer_returns'       => 'Devoluções',
		'doroshopping_ui_footer_legal_privacy' => 'Privacidade',
		'doroshopping_ui_footer_terms'         => 'Termos',
		'doroshopping_ui_footer_legal_notice'  => 'Aviso legal',
		'doroshopping_ui_footer_cookies'       => 'Cookies',
	);

	$packs = array(
		'en' => $en,
		'de' => $de,
		'fr' => $fr,
		'it' => $it,
		'pt' => $pt,
	);

	if ( function_exists( 'doroshopping_i18n_builtin_ui_page_packs' ) ) {
		$pages = doroshopping_i18n_builtin_ui_page_packs();
		foreach ( $packs as $lang => $rows ) {
			if ( ! empty( $pages[ $lang ] ) && is_array( $pages[ $lang ] ) ) {
				$packs[ $lang ] = array_merge( $rows, $pages[ $lang ] );
			}
		}
	}

	unset( $header_account_footer );

	return $packs;
}

/**
 * Texto embebido para una clave + idioma.
 *
 * @param string $key  Setting key.
 * @param string $lang Lang slug.
 * @return string
 */
function doroshopping_i18n_builtin_text( $key, $lang ) {
	$key  = (string) $key;
	$lang = sanitize_key( (string) $lang );
	if ( '' === $key || '' === $lang ) {
		return '';
	}

	$packs = doroshopping_i18n_builtin_ui_packs();
	if ( empty( $packs[ $lang ][ $key ] ) ) {
		return '';
	}

	return (string) $packs[ $lang ][ $key ];
}
