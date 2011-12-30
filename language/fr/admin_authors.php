<?php

/**
* @Project NUKEVIET 3.0
* @Author VINADES.,JSC (contact@vinades.vn)
* @Copyright (C) 2010 VINADES.,JSC. All rights reserved
* @Language Français
* @Createdate Jul 06, 2011, 04:38:02 PM
*/

 if (! defined('NV_ADMIN') or ! defined('NV_MAINFILE')){
 die('Stop!!!');
}

$lang_translator['author'] ="Phạm Chí Quang";
$lang_translator['createdate'] ="21/6/2010, 19:30";
$lang_translator['copyright'] ="@Copyright (C) 2010 VINADES.,JSC. Tous droits réservés.";
$lang_translator['info'] ="Langue française pour NukeViet 3";
$lang_translator['langtype'] ="lang_module";

$lang_module['level1'] = "Administrateur suprême";
$lang_module['level2'] = "Administrateur général";
$lang_module['level3'] = "Administrateur de module";
$lang_module['is_suspend0'] = "Actif";
$lang_module['is_suspend1'] = "Suspendu au &ldquo;%1\$s&rdquo; par &ldquo;%2\$s&rdquo; en raison &ldquo;%3\$s&rdquo;";
$lang_module['last_login0'] = "Jamais";
$lang_module['login'] = "Identifiant";
$lang_module['email'] = "E-mail";
$lang_module['full_name'] = "Nom complet";
$lang_module['sig'] = "Signature";
$lang_module['editor'] = "Éditeur";
$lang_module['lev'] = "Attributions";
$lang_module['position'] = "Fonction";
$lang_module['regtime'] = "Date de participation";
$lang_module['is_suspend'] = "Status actuel";
$lang_module['last_login'] = "Dernière session";
$lang_module['last_ip'] = "IP";
$lang_module['browser'] = "Navigateur";
$lang_module['os'] = "Système d'exploitation";
$lang_module['admin_info_title1'] = "Infos du compte: %s";
$lang_module['admin_info_title2'] = "Infos du compte: %s (c'est vous)";
$lang_module['menulist'] = "Administrateurs";
$lang_module['menuadd'] = "Ajouter un Administrateur";
$lang_module['main'] = "Liste des Administrateurs";
$lang_module['nv_admin_edit'] = "Mofifier les infos de l'administrateur";
$lang_module['nv_admin_add'] = "Ajouter l'administrateur";
$lang_module['nv_admin_del'] = "Supprimer l'administrateur";
$lang_module['username_incorrect'] = "Erreur: impossible de trouver le compte:%s";
$lang_module['full_name_incorrect'] = "Vous n'avez pas encore entré le nom de cet administateur";
$lang_module['position_incorrect'] = "Vous n'avez pas encore entré la fonction de cet administateur";
$lang_module['nv_admin_add_info'] = "Pour créer un nouveau compte d'administration, remplissez tous les champs ci-dessous. Vous ne pouvez créer qu'un administrateur inférieur de votre privilège";
$lang_module['if_level3_selected'] = "Cochez les modules à gérer";
$lang_module['login_info'] = "de &ldquo;<strong>%1\$d</strong>&rdquo; à &ldquo;<strong>%2\$d</strong>&rdquo; caractères. Utilisez uniquement les lettres latines, chiffres et tiret";
$lang_module['nv_admin_add_result'] = "Infos du nouveau administrateur";
$lang_module['nv_admin_add_title'] = "Le système a été créé un nouveau compte d'administration avec les infos ci-dessous";
$lang_module['nv_admin_modules'] = "Gestion de module";
$lang_module['admin_account_info'] = "Information de l'administrateur %s";
$lang_module['nv_admin_add_download'] = "Télécharger";
$lang_module['nv_admin_add_sendmail'] = "Envoyer la notification";
$lang_module['nv_admin_login_address'] = "Lien vers la section d'administration";
$lang_module['nv_admin_edit_info'] = "Modifier les infos du compte &ldquo;<strong>%s</strong>&rdquo;";
$lang_module['show_mail'] = "Afficher l'e-mail";
$lang_module['sig_info'] = "Cette signature sera insérée à la fin de chaque réponse, e-mail... envoyé par l'administrateur &ldquo;<strong>%s</strong>&rdquo;. Utilisez le texte brut sans mise en forme";
$lang_module['not_use'] = "non utilisé";
$lang_module['nv_admin_edit_result'] = "Changer les infos de l'administrateur: %s";
$lang_module['nv_admin_edit_result_title'] = "Les changements effectués pour le compte de l'administrateur %s";
$lang_module['show_mail0'] = "Masquer";
$lang_module['show_mail1'] = "Afficher";
$lang_module['field'] = "Domaine";
$lang_module['old_value'] = "Ancien";
$lang_module['new_value'] = "Nouveau";
$lang_module['chg_is_suspend0'] = "Le status actuel: suspendu. Pour Rétablir l'activité de cet administrateur, Remplissez les champs ci-dessous";
$lang_module['chg_is_suspend1'] = "Le status actuel: actif. Pour suspendre l'activité de cet administrateur, remplissez les champs ci-dessous";
$lang_module['chg_is_suspend2'] = "Rétablir/Suspendre l'activité";
$lang_module['nv_admin_chg_suspend'] = "Changer le status d'activité de l'administrateur &ldquo;<strong>%s</strong>&rdquo;";
$lang_module['position_info'] = "Le titre de Fonction est utilisé dans la communication des e-mails, des commentaires...";
$lang_module['susp_reason_empty'] = "Vous n'avez pas donné la raison de la suspension de l'administrateur &ldquo;<strong>%s</strong>&rdquo;";
$lang_module['suspend_info_empty'] = "Cet administrateur &ldquo;<strong>%s</strong>&rdquo; n'est jamais suspendu";
$lang_module['suspend_info_yes'] = "La liste des suspensions d'activité &ldquo;<strong>%s</strong>&rdquo;";
$lang_module['suspend_start'] = "Commencer";
$lang_module['suspend_end'] = "Terminer";
$lang_module['suspend_reason'] = "Raison de suspension";
$lang_module['suspend_info'] = "À: %1\$s<br />Par: %2\$s";
$lang_module['suspend0'] = "Rétablir l'activité";
$lang_module['suspend1'] = "Suspendre l'activité";
$lang_module['clean_history'] = "Supprimer l'historique";
$lang_module['suspend_sendmail'] = "Envoyer la notification";
$lang_module['suspend_sendmail_mess1'] = "L'administrateur du site %1\$s informe:<br />Votre compte d'administration sur le site %1\$s est suspendu au %2\$s en raison: %3\$s.<br />Toute proposition, question... merci d'envoyer à l'adresse %4\$s";
$lang_module['suspend_sendmail_mess0'] = "L'administration du site %1\$s informe:<br />Votre compte d'administration sur le site %1\$s est rétabli au %2\$s.<br />Ce compte avait été suspendu en raison: %3\$s";
$lang_module['suspend_sendmail_title'] = "Notification du site %s";
$lang_module['delete_sendmail_mess0'] = "L'administrateur du site %1\$s informe:<br />Votre compte d'administration sur le site %1\$s est supprimé au %2\$s.<br />Toute proposition, question... merci d'envoyer à l'adresse %3\$s";
$lang_module['delete_sendmail_mess1'] = "L'administrateur du site %1\$s informe:<br />Votre compte d'administration sur le site %1\$s est supprimé au %2\$s en raison de: %3\$s.<br />Toute proposition, question... merci d'envoyer à l'adresse %4\$s";
$lang_module['delete_sendmail_title'] = "Notification du site %s";
$lang_module['delete_sendmail_info'] = "Êtes vous sûr de vouloir supprimer le compte d'administration &ldquo;<strong>%s</strong>&rdquo;? Remplissez les infos aux champs ci-dessous pour confirmer cette opération";
$lang_module['admin_del_sendmail'] = "Envoyer la notification";
$lang_module['admin_del_reason'] = "Raison de la suppression";
$lang_module['allow_files_type'] = "Les types de fichiers authorisés";
$lang_module['allow_modify_files'] = "Authoriser la modification, la suppression des fichiers";
$lang_module['allow_create_subdirectories'] = "Authoriser la création des fichiers";
$lang_module['allow_modify_subdirectories'] = "Authoriser la modification, la suppression des répertoires";
$lang_module['admin_login_incorrect'] = "Le compte &ldquo;<strong>%s</strong>&rdquo; a été utilisé. Veuillez utiliser un autre nom";
$lang_module['config'] = "Configuration";
$lang_module['adminip'] = "Gestion de IP connecté à l'administration";
$lang_module['adminip_ip'] = "IP";
$lang_module['adminip_timeban'] = "Commencer";
$lang_module['adminip_timeendban'] = "Terminer";
$lang_module['adminip_funcs'] = "Fonctionalités";
$lang_module['adminip_checkall'] = "Sélectionner tout";
$lang_module['adminip_uncheckall'] = "Désélectionner tout";
$lang_module['adminip_add'] = "Ajouter IP";
$lang_module['adminip_address'] = "Adresse";
$lang_module['adminip_begintime'] = "Commencer";
$lang_module['adminip_endtime'] = "Terminer";
$lang_module['adminip_notice'] = "Note";
$lang_module['save'] = "Sauver";
$lang_module['adminip_mask_select'] = "Sélectionner";
$lang_module['adminip_nolimit'] = "Perpétuel";
$lang_module['adminip_del_success'] = "Suppression avec succès!";
$lang_module['adminip_delete_confirm'] = "Êtes-vous sûr de vouloir supprimer cet IP de la liste?";
$lang_module['adminip_mask'] = "Masque IP";
$lang_module['adminip_edit'] = "Éditer";
$lang_module['adminip_delete'] = "Supprimer";
$lang_module['adminip_error_ip'] = "Saisissez IP autorisé de connecter à l'administration";
$lang_module['adminip_error_validip'] = "Erreur: IP invalide";
$lang_module['adminip_note'] = "Attention: si vous activez le contrôle de IP, vous devez connaitre la structure des adresses IP: un IP se compose de 4 nombres sous forme A.B.C.D. Si tous ces nombres sont constants, sélectionnez le Masque 255.255.255.255. Si A, B  et C sont invariables, il faut choisir 255.255.255.xxx etc...";
$lang_module['title_username'] = "Gestion de compte Parefeu de l'Administration";
$lang_module['admfirewall'] = "Contrôler le Parefeu de l'Administration";
$lang_module['block_admin_ip'] = "Vérifier IP lors de la connexion de l'Administration";
$lang_module['username_add'] = "Ajouter un compte";
$lang_module['username_edit'] = "Éditer";
$lang_module['nicknam_delete_confirm'] = "Êtes-vous sûr de vouloir supprimer ce compte de la liste?";
$lang_module['passwordsincorrect'] = "Vous avez entré 2 mot de passe différents";
$lang_module['nochangepass'] = "Laisser vide 2 champs de mot de passe si vous ne voulez pas changer le mot de passe";
$lang_module['rule_user'] = "Utiliser uniquement les caractères a-zA-Z0-9_- pour le compte";
$lang_module['rule_pass'] = "Utiliser uniquement les caractères a-zA-Z0-9_- pour le mot de passe";
$lang_module['spadmin_add_admin'] = "Autoriser l'administrateur général de changer les droits des administrateurs de module";
$lang_module['authors_detail_main'] = "Afficher les détails du compte de l'administrateur";

?>