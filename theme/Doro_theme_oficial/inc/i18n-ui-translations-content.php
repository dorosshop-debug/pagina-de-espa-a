<?php
/**
 * UI translations for content, CMS, 404 and search pages.
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @return array<string, array<string, string>>
 */
function doroshopping_i18n_builtin_ui_content_packs() {
	$entries = array(
		// CMS, 404 and search.
		'doroshopping_ui_cms_eyebrow_legal' => array( 'Legal information', 'Rechtliche Informationen', 'Informations légales', 'Informazioni legali', 'Informação legal' ),
		'doroshopping_ui_cms_eyebrow_info' => array( 'Shopping guide', 'Einkaufsratgeber', 'Guide d’achat', 'Guida agli acquisti', 'Guia de compras' ),
		'doroshopping_ui_cms_updated' => array( 'Last updated: %s', 'Letzte Aktualisierung: %s', 'Dernière mise à jour : %s', 'Ultimo aggiornamento: %s', 'Última atualização: %s' ),
		'doroshopping_ui_cms_toc_aria' => array( 'Page contents', 'Seiteninhalt', 'Sommaire de la page', 'Indice della pagina', 'Índice da página' ),
		'doroshopping_ui_cms_toc_title' => array( 'On this page', 'Auf dieser Seite', 'Sur cette page', 'In questa pagina', 'Nesta página' ),
		'doroshopping_ui_cms_related_aria' => array( 'Related pages', 'Verwandte Seiten', 'Pages associées', 'Pagine correlate', 'Páginas relacionadas' ),
		'doroshopping_ui_cms_related_title' => array( 'You may also be interested in', 'Das könnte Sie auch interessieren', 'Cela peut aussi vous intéresser', 'Potrebbe interessarti anche', 'Também pode interessar-lhe' ),
		'doroshopping_ui_cms_footer_links' => array( 'Useful links', 'Nützliche Links', 'Liens utiles', 'Link utili', 'Ligações úteis' ),
		'doroshopping_ui_cms_rel_payments' => array( 'Payment methods', 'Zahlungsmethoden', 'Moyens de paiement', 'Metodi di pagamento', 'Métodos de pagamento' ),
		'doroshopping_ui_cms_rel_shipping' => array( 'Shipping', 'Versand', 'Livraison', 'Spedizioni', 'Envios' ),
		'doroshopping_ui_cms_rel_protect' => array( 'Buyer protection', 'Käuferschutz', 'Protection de l’acheteur', 'Protezione dell’acquirente', 'Proteção do comprador' ),
		'doroshopping_ui_cms_rel_returns' => array( 'Returns', 'Rückgaben', 'Retours', 'Resi', 'Devoluções' ),
		'doroshopping_ui_cms_rel_terms' => array( 'Terms', 'Bedingungen', 'Conditions', 'Termini', 'Termos' ),
		'doroshopping_ui_cms_rel_legal' => array( 'Legal notice', 'Impressum', 'Mentions légales', 'Note legali', 'Aviso legal' ),
		'doroshopping_ui_cms_rel_cookies' => array( 'Cookies', 'Cookies', 'Cookies', 'Cookie', 'Cookies' ),
		'doroshopping_ui_cms_rel_privacy' => array( 'Privacy', 'Datenschutz', 'Confidentialité', 'Privacy', 'Privacidade' ),
		'doroshopping_ui_cms_rel_help' => array( 'Help centre', 'Hilfe-Center', 'Centre d’aide', 'Centro assistenza', 'Centro de ajuda' ),
		'doroshopping_ui_404_title' => array( 'Page not found', 'Seite nicht gefunden', 'Page introuvable', 'Pagina non trovata', 'Página não encontrada' ),
		'doroshopping_ui_404_lead' => array( 'The page you are looking for does not exist, has moved or is no longer available.', 'Die gesuchte Seite existiert nicht, wurde verschoben oder ist nicht mehr verfügbar.', 'La page que vous recherchez n’existe pas, a été déplacée ou n’est plus disponible.', 'La pagina che cerchi non esiste, è stata spostata o non è più disponibile.', 'A página que procura não existe, foi movida ou já não está disponível.' ),
		'doroshopping_ui_404_home_btn' => array( 'Back to home', 'Zur Startseite', 'Retour à l’accueil', 'Torna alla home', 'Voltar ao início' ),
		'doroshopping_ui_404_shop_btn' => array( 'Go to shop', 'Zum Shop', 'Aller à la boutique', 'Vai al negozio', 'Ir à loja' ),
		'doroshopping_ui_search_title' => array( 'Results for: %s', 'Ergebnisse für: %s', 'Résultats pour : %s', 'Risultati per: %s', 'Resultados para: %s' ),
		'doroshopping_ui_search_empty' => array( 'No results found.', 'Keine Ergebnisse gefunden.', 'Aucun résultat trouvé.', 'Nessun risultato trovato.', 'Não foram encontrados resultados.' ),
		'doroshopping_ui_search_home' => array( 'Back to home', 'Zur Startseite', 'Retour à l’accueil', 'Torna alla home', 'Voltar ao início' ),

		// About.
		'doroshopping_ui_about_eyebrow' => array( 'Brand', 'Marke', 'Marque', 'Marchio', 'Marca' ),
		'doroshopping_ui_about_title' => array( 'About us', 'Über uns', 'À propos de nous', 'Chi siamo', 'Sobre nós' ),
		'doroshopping_ui_about_lead' => array( 'Online shop for Spain and Europe with a practical selection of products for everyday life.', 'Onlineshop für Spanien und Europa mit einer praktischen Produktauswahl für den Alltag.', 'Boutique en ligne pour l’Espagne et l’Europe avec une sélection pratique de produits du quotidien.', 'Negozio online per la Spagna e l’Europa con una pratica selezione di prodotti per la vita quotidiana.', 'Loja online para Espanha e Europa com uma seleção prática de produtos para o dia a dia.' ),
		'doroshopping_ui_about_who_title' => array( 'Who we are', 'Wer wir sind', 'Qui sommes-nous', 'Chi siamo', 'Quem somos' ),
		'doroshopping_ui_about_who_text' => array( 'We are an online shop for electronics, home, sports and consumer products. We work with international suppliers to offer a varied catalogue, shipping to Spain and Europe, and Spanish-speaking customer support.', 'Wir sind ein Onlineshop für Elektronik-, Haushalts-, Sport- und Konsumprodukte. Mit internationalen Lieferanten bieten wir ein vielfältiges Sortiment, Versand nach Spanien und Europa sowie spanischsprachigen Kundenservice.', 'Nous sommes une boutique en ligne d’électronique, de maison, de sport et de produits de consommation. Nous travaillons avec des fournisseurs internationaux pour proposer un catalogue varié, des livraisons en Espagne et en Europe, ainsi qu’un service client en espagnol.', 'Siamo un negozio online di elettronica, casa, sport e prodotti di consumo. Collaboriamo con fornitori internazionali per offrire un catalogo vario, spedizioni in Spagna e in Europa e assistenza clienti in spagnolo.', 'Somos uma loja online de eletrónica, casa, desporto e produtos de consumo. Trabalhamos com fornecedores internacionais para oferecer um catálogo variado, envios para Espanha e Europa e apoio ao cliente em espanhol.' ),
		'doroshopping_ui_about_reach_title' => array( 'Our reach', 'Unsere Reichweite', 'Notre présence', 'La nostra portata', 'O nosso alcance' ),
		'doroshopping_ui_about_reach_1_title' => array( 'Supplier catalogue', 'Lieferantenkatalog', 'Catalogue de fournisseurs', 'Catalogo fornitori', 'Catálogo de fornecedores' ),
		'doroshopping_ui_about_reach_1_text' => array( 'A wide selection of products from international suppliers.', 'Eine große Produktauswahl internationaler Lieferanten.', 'Une large sélection de produits de fournisseurs internationaux.', 'Un’ampia selezione di prodotti da fornitori internazionali.', 'Uma ampla seleção de produtos de fornecedores internacionais.' ),
		'doroshopping_ui_about_reach_2_title' => array( 'Shipping to Spain and the EU', 'Versand nach Spanien und in die EU', 'Livraisons en Espagne et dans l’UE', 'Spedizioni in Spagna e nell’UE', 'Envios para Espanha e UE' ),
		'doroshopping_ui_about_reach_2_text' => array( 'We deliver to Spain and destinations in the European Union.', 'Wir liefern nach Spanien und an Ziele in der Europäischen Union.', 'Nous livrons en Espagne et dans les pays de l’Union européenne.', 'Consegniamo in Spagna e nelle destinazioni dell’Unione Europea.', 'Entregamos em Espanha e em destinos da União Europeia.' ),
		'doroshopping_ui_about_reach_3_title' => array( 'Secure payments', 'Sichere Zahlungen', 'Paiements sécurisés', 'Pagamenti sicuri', 'Pagamentos seguros' ),
		'doroshopping_ui_about_reach_3_text' => array( 'Payments are processed through the secure gateways available at checkout.', 'Zahlungen werden über die an der Kasse verfügbaren sicheren Zahlungsanbieter verarbeitet.', 'Les paiements sont traités par les passerelles sécurisées disponibles au checkout.', 'I pagamenti sono elaborati tramite i gateway sicuri disponibili al checkout.', 'Os pagamentos são processados através dos meios seguros disponíveis no checkout.' ),
		'doroshopping_ui_about_reach_4_title' => array( 'Support in Spanish', 'Support auf Spanisch', 'Assistance en espagnol', 'Assistenza in spagnolo', 'Apoio em espanhol' ),
		'doroshopping_ui_about_reach_4_text' => array( 'Our team assists you in Spanish before and after your purchase.', 'Unser Team unterstützt Sie vor und nach Ihrem Einkauf auf Spanisch.', 'Notre équipe vous accompagne en espagnol avant et après votre achat.', 'Il nostro team ti assiste in spagnolo prima e dopo l’acquisto.', 'A nossa equipa presta-lhe apoio em espanhol antes e depois da compra.' ),
		'doroshopping_ui_about_commit_title' => array( 'Our commitment', 'Unser Engagement', 'Notre engagement', 'Il nostro impegno', 'O nosso compromisso' ),
		'doroshopping_ui_about_commit_text' => array( 'We seek competitive prices and a transparent purchase, with clear information about products, payments, shipping and returns.', 'Wir setzen auf wettbewerbsfähige Preise und transparente Einkäufe mit klaren Informationen zu Produkten, Zahlungen, Versand und Rückgaben.', 'Nous visons des prix compétitifs et un achat transparent, avec des informations claires sur les produits, les paiements, la livraison et les retours.', 'Puntiamo a prezzi competitivi e a un acquisto trasparente, con informazioni chiare su prodotti, pagamenti, spedizioni e resi.', 'Procuramos preços competitivos e uma compra transparente, com informação clara sobre produtos, pagamentos, envios e devoluções.' ),
		'doroshopping_ui_about_cta_help' => array( 'Help centre', 'Hilfe-Center', 'Centre d’aide', 'Centro assistenza', 'Centro de ajuda' ),
		'doroshopping_ui_about_cta_shop' => array( 'Go to shop', 'Zum Shop', 'Aller à la boutique', 'Vai al negozio', 'Ir à loja' ),

		// Contact.
		'doroshopping_ui_contact_eyebrow' => array( 'Contact', 'Kontakt', 'Contact', 'Contatti', 'Contacto' ),
		'doroshopping_ui_contact_title' => array( 'We are here to help', 'Wir sind für Sie da', 'Nous sommes là pour vous aider', 'Siamo qui per aiutarti', 'Estamos aqui para ajudar' ),
		'doroshopping_ui_contact_lead' => array( 'For questions about orders, payments, shipping or returns, contact our customer service team.', 'Bei Fragen zu Bestellungen, Zahlungen, Versand oder Rückgaben wenden Sie sich an unseren Kundenservice.', 'Pour toute question sur les commandes, les paiements, la livraison ou les retours, contactez notre service client.', 'Per domande su ordini, pagamenti, spedizioni o resi, contatta il nostro servizio clienti.', 'Para questões sobre encomendas, pagamentos, envios ou devoluções, contacte a nossa equipa de apoio ao cliente.' ),
		'doroshopping_ui_contact_form_cta_title' => array( 'How can we help?', 'Wie können wir helfen?', 'Comment pouvons-nous vous aider ?', 'Come possiamo aiutarti?', 'Como podemos ajudar?' ),
		'doroshopping_ui_contact_form_cta_text' => array( 'Send us the details of your query through the Help centre so we can give you an appropriate response.', 'Senden Sie uns die Details Ihrer Anfrage über das Hilfe-Center, damit wir Ihnen passend antworten können.', 'Envoyez-nous les détails de votre demande via le Centre d’aide afin que nous puissions vous répondre au mieux.', 'Inviaci i dettagli della richiesta tramite il Centro assistenza per poterti rispondere in modo adeguato.', 'Envie-nos os detalhes da sua questão através do Centro de ajuda para lhe podermos dar uma resposta adequada.' ),
		'doroshopping_ui_contact_form_btn' => array( 'Go to Help centre', 'Zum Hilfe-Center', 'Aller au Centre d’aide', 'Vai al Centro assistenza', 'Ir para o Centro de ajuda' ),
		'doroshopping_ui_contact_email_title' => array( 'Email', 'E-Mail', 'E-mail', 'E-mail', 'E-mail' ),
		'doroshopping_ui_contact_email_text' => array( 'Write to us and we will reply as soon as possible.', 'Schreiben Sie uns, wir antworten schnellstmöglich.', 'Écrivez-nous et nous vous répondrons dès que possible.', 'Scrivici e ti risponderemo al più presto.', 'Escreva-nos e responderemos assim que possível.' ),
		'doroshopping_ui_contact_hours_title' => array( 'Customer service hours', 'Servicezeiten', 'Horaires du service client', 'Orari del servizio clienti', 'Horário de atendimento' ),
		'doroshopping_ui_contact_hours_text' => array( 'Monday to Friday, 9:00–18:00 CET. We usually reply by email within 24–48 business hours.', 'Montag bis Freitag, 9:00–18:00 CET. Wir antworten normalerweise innerhalb von 24–48 Arbeitsstunden per E-Mail.', 'Du lundi au vendredi, de 9 h à 18 h CET. Nous répondons habituellement par e-mail sous 24 à 48 h ouvrées.', 'Dal lunedì al venerdì, 9:00–18:00 CET. Di solito rispondiamo via e-mail entro 24–48 ore lavorative.', 'De segunda a sexta, 9:00–18:00 CET. Normalmente respondemos por e-mail em 24–48 horas úteis.' ),
		'doroshopping_ui_contact_links_title' => array( 'Quick links', 'Schnellzugriff', 'Liens rapides', 'Link rapidi', 'Ligações rápidas' ),
		'doroshopping_ui_contact_link_faq' => array( 'Frequently asked questions', 'Häufig gestellte Fragen', 'Questions fréquentes', 'Domande frequenti', 'Perguntas frequentes' ),
		'doroshopping_ui_contact_link_shipping' => array( 'Shipping information', 'Versandinformationen', 'Informations de livraison', 'Informazioni sulla spedizione', 'Informações de envio' ),
		'doroshopping_ui_contact_link_returns' => array( 'Returns and refunds', 'Rückgaben und Erstattungen', 'Retours et remboursements', 'Resi e rimborsi', 'Devoluções e reembolsos' ),
		'doroshopping_ui_contact_link_payments' => array( 'Payment methods', 'Zahlungsmethoden', 'Moyens de paiement', 'Metodi di pagamento', 'Métodos de pagamento' ),

		// Returns.
		'doroshopping_ui_returns_eyebrow' => array( 'Returns', 'Rückgaben', 'Retours', 'Resi', 'Devoluções' ),
		'doroshopping_ui_returns_title' => array( 'Returns policy', 'Rückgaberichtlinie', 'Politique de retours', 'Politica dei resi', 'Política de devoluções' ),
		'doroshopping_ui_returns_lead' => array( 'Learn how to request a return, your rights and the refund process.', 'Erfahren Sie, wie Sie eine Rückgabe beantragen, welche Rechte Sie haben und wie die Erstattung erfolgt.', 'Découvrez comment demander un retour, vos droits et le processus de remboursement.', 'Scopri come richiedere un reso, i tuoi diritti e la procedura di rimborso.', 'Saiba como solicitar uma devolução, os seus direitos e o processo de reembolso.' ),
		'doroshopping_ui_returns_howto_title' => array( 'How to request a return', 'So beantragen Sie eine Rückgabe', 'Comment demander un retour', 'Come richiedere un reso', 'Como solicitar uma devolução' ),
		'doroshopping_ui_returns_s1_title' => array( 'Request your return', 'Rückgabe beantragen', 'Demandez votre retour', 'Richiedi il reso', 'Solicite a devolução' ),
		'doroshopping_ui_returns_s1_text' => array( 'Contact us within 14 days of receiving your order.', 'Kontaktieren Sie uns innerhalb von 14 Tagen nach Erhalt Ihrer Bestellung.', 'Contactez-nous dans les 14 jours suivant la réception de votre commande.', 'Contattaci entro 14 giorni dalla ricezione dell’ordine.', 'Contacte-nos nos 14 dias seguintes à receção da encomenda.' ),
		'doroshopping_ui_returns_s2_title' => array( 'Prepare the package', 'Paket vorbereiten', 'Préparez le colis', 'Prepara il pacco', 'Prepare a embalagem' ),
		'doroshopping_ui_returns_s2_text' => array( 'Pack the product carefully, preferably in its original packaging and with all accessories.', 'Verpacken Sie das Produkt sorgfältig, vorzugsweise in der Originalverpackung und mit allen Zubehörteilen.', 'Emballez soigneusement le produit, de préférence dans son emballage d’origine et avec tous ses accessoires.', 'Imballa con cura il prodotto, preferibilmente nella confezione originale e con tutti gli accessori.', 'Embale cuidadosamente o produto, de preferência na embalagem original e com todos os acessórios.' ),
		'doroshopping_ui_returns_s3_title' => array( 'Receive your refund', 'Erstattung erhalten', 'Recevez votre remboursement', 'Ricevi il rimborso', 'Receba o reembolso' ),
		'doroshopping_ui_returns_s3_text' => array( 'We will refund the original payment method after receiving and inspecting the return.', 'Nach Erhalt und Prüfung der Rückgabe erstatten wir über die ursprüngliche Zahlungsmethode.', 'Nous rembourserons le moyen de paiement d’origine après réception et vérification du retour.', 'Rimborseremo il metodo di pagamento originale dopo aver ricevuto e verificato il reso.', 'Processaremos o reembolso para o método de pagamento original após recebermos e verificarmos a devolução.' ),
		'doroshopping_ui_returns_rights_title' => array( 'Your rights', 'Ihre Rechte', 'Vos droits', 'I tuoi diritti', 'Os seus direitos' ),
		'doroshopping_ui_returns_rights_1' => array( 'In the EU, you generally have 14 days to exercise your right of withdrawal.', 'In der EU haben Sie in der Regel 14 Tage Zeit, Ihr Widerrufsrecht auszuüben.', 'Dans l’UE, vous disposez généralement de 14 jours pour exercer votre droit de rétractation.', 'Nell’UE, di norma hai 14 giorni per esercitare il diritto di recesso.', 'Na UE, tem geralmente 14 dias para exercer o direito de livre resolução.' ),
		'doroshopping_ui_returns_rights_2' => array( 'The product must be returned in good condition and, where possible, in its original packaging.', 'Das Produkt muss in gutem Zustand und möglichst in der Originalverpackung zurückgesendet werden.', 'Le produit doit être retourné en bon état et, si possible, dans son emballage d’origine.', 'Il prodotto deve essere restituito in buone condizioni e, quando possibile, nella confezione originale.', 'O produto deve ser devolvido em bom estado e, quando possível, na embalagem original.' ),
		'doroshopping_ui_returns_rights_3' => array( 'Some items may be subject to legal exceptions due to their nature or conditions of use.', 'Für einige Artikel können aufgrund ihrer Beschaffenheit oder Nutzungsbedingungen gesetzliche Ausnahmen gelten.', 'Certains articles peuvent faire l’objet d’exceptions légales en raison de leur nature ou de leurs conditions d’utilisation.', 'Alcuni articoli possono essere soggetti a eccezioni legali per la loro natura o le condizioni d’uso.', 'Alguns artigos podem estar sujeitos a exceções legais devido à sua natureza ou condições de utilização.' ),
		'doroshopping_ui_returns_process_title' => array( 'Refund process', 'Erstattungsprozess', 'Processus de remboursement', 'Procedura di rimborso', 'Processo de reembolso' ),
		'doroshopping_ui_returns_process_1' => array( 'We will confirm the return instructions after reviewing your request.', 'Nach Prüfung Ihrer Anfrage bestätigen wir Ihnen die Rückgabeanweisungen.', 'Nous vous confirmerons les instructions de retour après examen de votre demande.', 'Ti confermeremo le istruzioni per il reso dopo aver esaminato la richiesta.', 'Confirmaremos as instruções de devolução após analisarmos o seu pedido.' ),
		'doroshopping_ui_returns_process_2' => array( 'When the parcel arrives, we will check the condition of the returned product.', 'Sobald das Paket eintrifft, prüfen wir den Zustand des zurückgesendeten Produkts.', 'À l’arrivée du colis, nous vérifierons l’état du produit retourné.', 'Quando il pacco arriverà, verificheremo lo stato del prodotto restituito.', 'Quando a encomenda chegar, verificaremos o estado do produto devolvido.' ),
		'doroshopping_ui_returns_process_3' => array( 'The refund is made to the original payment method; your bank may take several business days to show it.', 'Die Erstattung erfolgt über die ursprüngliche Zahlungsmethode; Ihre Bank kann mehrere Werktage benötigen, um sie anzuzeigen.', 'Le remboursement est effectué sur le moyen de paiement d’origine ; votre banque peut mettre plusieurs jours ouvrés à l’afficher.', 'Il rimborso viene effettuato sul metodo di pagamento originale; la banca potrebbe impiegare vari giorni lavorativi per mostrarlo.', 'O reembolso é efetuado para o método de pagamento original; o seu banco pode demorar vários dias úteis a refletir o valor.' ),
		'doroshopping_ui_returns_help_title' => array( 'Need help with a return?', 'Benötigen Sie Hilfe bei einer Rückgabe?', 'Besoin d’aide pour un retour ?', 'Hai bisogno di aiuto con un reso?', 'Precisa de ajuda com uma devolução?' ),
		'doroshopping_ui_returns_help_text' => array( 'Write to us with your order number and the details of your case.', 'Schreiben Sie uns mit Ihrer Bestellnummer und den Details Ihres Falls.', 'Écrivez-nous avec votre numéro de commande et les détails de votre situation.', 'Scrivici con il numero d’ordine e i dettagli del tuo caso.', 'Escreva-nos com o número da encomenda e os detalhes do seu caso.' ),
		'doroshopping_ui_returns_help_btn' => array( 'Go to Help centre', 'Zum Hilfe-Center', 'Aller au Centre d’aide', 'Vai al Centro assistenza', 'Ir para o Centro de ajuda' ),
		'doroshopping_ui_returns_protect_btn' => array( 'Buyer protection', 'Käuferschutz', 'Protection de l’acheteur', 'Protezione dell’acquirente', 'Proteção do comprador' ),
	);

	$packs = array( 'en' => array(), 'de' => array(), 'fr' => array(), 'it' => array(), 'pt' => array() );
	foreach ( $entries as $key => $texts ) {
		$packs['en'][ $key ] = $texts[0];
		$packs['de'][ $key ] = $texts[1];
		$packs['fr'][ $key ] = $texts[2];
		$packs['it'][ $key ] = $texts[3];
		$packs['pt'][ $key ] = $texts[4];
	}

	return $packs;
}
