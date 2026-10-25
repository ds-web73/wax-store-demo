# Wax Store – démonstration

Démonstration en ligne du thème **Wax Store** et de l'extension **Wax Store Catalog**,
par DS-Web, avec [WordPress Playground](https://wordpress.org/playground/) :
un WordPress complet qui tourne dans le navigateur.

**[Essayer la démo](https://playground.wordpress.net/?blueprint-url=https://raw.githubusercontent.com/ds-web73/wax-store-demo/main/blueprint.json)**

Chaque visiteur reçoit sa propre copie du site, déjà connecté en administrateur
(identifiant `admin`, mot de passe `password`). Rien n'est conservé : tout
disparaît à la fermeture de l'onglet.

## Ce que contient la démo

- Un disquaire fictif, « Le Bac à Vinyles », avec ses réglages complets.
- Une trentaine de références : vinyles 33 et 45 tours, maxis, CD, cassette,
  t-shirt ; neufs et d'occasion, gradés Goldmine ; disques vendus et réservés ;
  plusieurs exemplaires d'un même pressage ; genres et sous-genres ; tracklists.
- Les pages Accueil, Réserver un disque, Vendez-nous vos disques, Infos pratiques
  et Mentions légales.
- Une demande de réservation, une alerte et une proposition de rachat, visibles
  dans Disquaire > Demandes clients.

Les pochettes sont des images abstraites créées pour cette démo : aucune
illustration de disque réel n'est utilisée.

## Limites

Les envois d'e-mails et les services extérieurs (pochettes automatiques) ne
fonctionnent pas dans Playground. Les formulaires enregistrent bien les demandes.

## Contenu du dépôt

- `blueprint.json` : la recette de la démo (langue, thème, extension, contenu).
  Le thème et l'extension sont chargés depuis les dépôts `ds-web73/wax-store`
  et `ds-web73/wax-store-catalog` : la démo suit leurs mises à jour.
- `demo-content.zip` : le script de mise en place et les pochettes, téléchargés
  par le blueprint. Régénérer l'archive après toute modification de `demo-content/`.
- `demo-content/` : les mêmes fichiers, lisibles.

Licence : GPL-2.0 ou ultérieure.
