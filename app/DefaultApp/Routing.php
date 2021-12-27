<?php
use app\DefaultApp\DefaultApp as App;
App::get("/", "default.index", "index");
App::post("/", "default.index","index_post");
App::get("info-dashboard", "default.infosDashboard", "info_dashboard");

//login logout
App::post("login","default.login");
App::post("logout","default.logout");
//fin login logout

//code jeux
App::post("code-jeux","codeJeux.add");
App::post("ajouter-prime","codeJeux.addPrime");
App::post("lister-prime","codeJeux.getsPrime");
App::put("code-jeux","codeJeux.update");
App::get("code-jeux/:id","codeJeux.get")->avec("id","[0-9]+");
App::get("code-jeux","codeJeux.gets");
App::delete("code-jeux/:id","codeJeux.delete")->avec("id","[0-9]+");
App::post("ajouter-numero","codeJeux.addNumero");
App::post("lister-numero","codeJeux.getsNumero");
App::post("ajouter-limite","codeJeux.addLimite");


App::post("ajouter-numero-bloquer","codeJeux.addNumeroBloquer");
App::get("numero-bloquer","codeJeux.numeroBloquer");
App::get("supprimer-numero-bloquer-:id","codeJeux.supprimerNumeroBloquer")->avec("id","[0-9]+");
//fin code jeux autre lien



//client
App::post("client","client.add");
App::put("client","client.update");
App::get("client/:id","client.get")->avec("id","[0-9]+");
App::get("client","client.gets");
App::delete("client/:id","client.delete")->avec("id","[0-9]+");
App::get("client/default","client.getDefaultClient");
App::get("client/total","client.total");
App::post("depot-credit","client.depotCredit");
App::post("retrait-balance","client.retraitBalance");
//fin client


//vendeur
App::post("vendeur","vendeur.add");
App::put("vendeur","vendeur.update");
App::get("vendeur/:id","vendeur.get")->avec("id","[0-9]+");
App::get("vendeur","vendeur.gets");
App::delete("vendeur/:id","vendeur.delete")->avec("id","[0-9]+");
App::get("vendeur/total","vendeur.total");
App::post("vendeur/modifier-password","vendeur.modifierPassword");
App::post("vendeur/save-token","vendeur.saveToken","save_token");
//fin vendeur

//vente
App::post("vente","vente.add");
App::put("vente","vente.update");
App::get("vente/:id","vente.get")->avec("id","[0-9]+");
App::get("vente","vente.gets");
App::post("eliminer-vente","vente.eliminer");
App::post("vente/confirmerElimination","vente.confimerElimination");
App::get("vente/par-pos-:imei","vente.getVenteParPos")->avec("imei","[0-9a-z\-\/]+");
App::get("vente/rapport","vente.getRapport");
App::get("vente/par-ticket-:ticket","vente.getParTicket")->avec("ticket","[0-9a-z\-]+");

App::get("vente/get-motif-elimination","vente.getMotifElimination");
App::post("vente/add-motif-elimination","vente.addMotifElimination");
App::put("vente/update-motif-elimination","vente.updateMotifElimination");
App::delete("vente/delete-motif/:id","vente.deleteMotif")->avec("id","[0-9]+");
App::put("payer-ticket/:id","vente.payerTicket")->avec("id","[0-9]+");
App::get("vente/total-vente","vente.totalVente");
App::get("vente/total-fiche-eliminer","vente.totalFicheEliminer");
App::get("vente-vendeur-date-tirage","vente.getVenteVendeurDateTirage");
App::get("vente-vendeur-date","vente.getVenteVendeurDate");
App::get("liste-paris-par-date","vente.listeParisParDate");
App::get("rapport-vente-vendeur","vente.getRapportVendeur");
App::get("rapport-vente","vente.getRapport");
App::get("statistique","vente.statistique","statistique");
//fin vente

//Tirage
App::post("tirage","tirage.add");
App::put("tirage","tirage.update");
App::get("tirage/:id","tirage.get")->avec("id","[0-9]+");
App::get("tirage","tirage.gets");
App::delete("tirage/:id","tirage.delete")->avec("id","[0-9]+");
App::get("fermer-tirage","tirage.fermer");

App::post("fermer-imediatement/:id","tirage.fermerImediatement")->avec("id","[0-9]+");
App::post("programmer-fermeture/:id","tirage.programmerFermeture")->avec("id","[0-9]+");
//fin Tirage

//Tirage
App::post("utilisateur","utilisateur.add");
App::put("utilisateur","utilisateur.update");
App::get("utilisateur/:id","utilisateur.get")->avec("id","[0-9]+");
App::get("utilisateur","utilisateur.gets");
App::delete("utilisateur/:id","utilisateur.delete")->avec("id","[0-9]+");
App::get("utilisateur/total","utilisateur.total");
App::get("utilisateur/superviseur","utilisateur.getsSuperviseur");
//fin Tirage

//lot gagnants
App::post("lot-gagnant","lotGagnant.add");
App::put("lot-gagnant","lotGagnant.update");
App::get("lot-gagnant/:id","lotGagnant.get")->avec("id","[0-9]+");
App::get("lot-gagnant","lotGagnant.gets");
App::get("lot-gagnant-date-tirage","lotGagnant.getParDateTirage");
App::delete("lot-gagnant/:id","lotGagnant.delete")->avec("id","[0-9]+");
App::get("get-billet-gagnant","lotGagnant.getBilletGagnant");
App::get("get-billet-gagnant-payer","lotGagnant.getBilletGagnantPayer");
App::get("get-billet-gagnant-tout","lotGagnant.getBilletGagnantTout");
App::get("get-lot-gagnant-from-magayo-midi","lotGagnant.getLotGagnantFromMagayoMidi");

//fin lot gagnants

//pos
App::put("pos/update-position","pos.updatePosition");
App::post("pos","pos.add");
App::put("pos","pos.update");
App::get("pos/:id","pos.get")->avec("id","[0-9]+");
App::get("pos","pos.gets");
App::delete("pos/:id","pos.delete")->avec("id","[0-9]+");
App::post("pos/activer-:id","pos.activer")->avec("id","[0-9]+");
App::post("pos/desactiver-:id","pos.desactiver")->avec("id","[0-9]+");
App::post("pos/fermer-:id","pos.fermer")->avec("id","[0-9]+");
//pos

//banque
App::post("banque","banque.add");
App::put("banque","banque.update");
App::get("banque/:id","banque.get")->avec("id","[0-9]+");
App::get("banque","banque.gets");
App::delete("banque/:id","banque.delete")->avec("id","[0-9]+");
//banque

//branche
App::post("branche","branche.add");
App::put("branche","branche.update");
App::get("branche/:id","branche.get")->avec("id","[0-9]+");
App::get("branche","branche.gets");
App::delete("branche/:id","branche.delete")->avec("id","[0-9]+");
App::get("branche-par-reseau/:id","branche.getsParReseau")->avec("id","[0-9]+");
//branche

//lotterie
App::post("lotterie","lotterie.add");
App::put("lotterie","lotterie.update");
App::get("lotterie/:id","lotterie.get")->avec("id","[0-9]+");
App::get("lotterie","lotterie.gets");
App::delete("lotterie/:id","lotterie.delete")->avec("id","[0-9]+");
//lotterie

//departement
App::post("departement","departement.add");
App::put("departement","departement.update");
App::get("departement/:id","departement.get")->avec("id","[0-9]+");
App::get("departement","departement.gets");
App::delete("departement/:id","departement.delete")->avec("id","[0-9]+");
App::get("departement-par-groupe/:id","departement.getsDepartementParGroupe")->avec("id","[0-9]+");
//departement

//posVendeur
App::post("pos-vendeur","posVendeur.add");
App::put("pos-vendeur","posVendeur.update");
App::get("pos-vendeur/:id","posVendeur.get")->avec("id","[0-9]+");
App::get("pos-vendeur","posVendeur.gets");
App::delete("pos-vendeur/:id","posVendeur.delete")->avec("id","[0-9]+");
//posVendeur

//reseau globale
App::post("reseau-globale","reseauGlobale.add");
App::put("reseau-globale","reseauGlobale.update");
App::get("reseau-globale/:id","reseauGlobale.get")->avec("id","[0-9]+");
App::get("reseau-globale","reseauGlobale.gets");
App::delete("reseau-globale/:id","reseauGlobale.delete")->avec("id","[0-9]+");
//reseau globale

//groupe
App::post("groupe","groupe.add");
App::put("groupe","groupe.update");
App::get("groupe/:id","groupe.get")->avec("id","[0-9]+");
App::get("groupe","groupe.gets");
App::delete("groupe/:id","groupe.delete")->avec("id","[0-9]+");
App::get("groupe-par-departement/:id","groupe.getsGroupeParDepartement")->avec("id","[0-9]+");
//groupe

//reseau
App::post("reseau","reseau.add");
App::put("reseau","reseau.update");
App::get("reseau/:id","reseau.get")->avec("id","[0-9]+");
App::get("reseau-par-groupe/:id","reseau.getsReseauParGroupe")->avec("id","[0-9]+");
App::get("reseau","reseau.gets");
App::delete("reseau/:id","reseau.delete")->avec("id","[0-9]+");
//reseau

//message promotion
App::post("message","messagePromotion.add");
App::get("message-liste-message","messagePromotion.listeMessage");
App::get("message-liste-promotion","messagePromotion.listePromotion");
App::get("supprimer-message-:id","messagePromotion.delete")->avec("id","[0-9]+");
//fin message promotion
