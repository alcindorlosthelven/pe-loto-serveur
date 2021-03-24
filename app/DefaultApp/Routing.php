<?php
use app\DefaultApp\DefaultApp as App;
App::get("/", "default.index", "index");
App::post("/", "default.index","index_post");

//login logout
App::post("login","default.login");
App::post("logout","default.logout");


//fin login logout


//code jeux
App::post("code-jeux","codeJeux.add");
App::put("code-jeux","codeJeux.update");
App::get("code-jeux/:id","codeJeux.get")->avec("id","[0-9]+");
App::get("code-jeux","codeJeux.gets");
App::delete("code-jeux/:id","codeJeux.delete")->avec("id","[0-9]+");
//fin code jeux autre lien


//client
App::post("client","client.add");
App::put("client","client.update");
App::get("client/:id","client.get")->avec("id","[0-9]+");
App::get("client","client.gets");
App::delete("client/:id","client.delete")->avec("id","[0-9]+");
App::get("client/default","client.getDefaultClient");
App::get("client/total","client.total");
//fin client


//vendeur
App::post("vendeur","vendeur.add");
App::put("vendeur","vendeur.update");
App::get("vendeur/:id","vendeur.get")->avec("id","[0-9]+");
App::get("vendeur","vendeur.gets");
App::delete("vendeur/:id","vendeur.delete")->avec("id","[0-9]+");
App::get("vendeur/total","vendeur.total");
//fin vendeur


//vente
App::post("vente","vente.add");
App::put("vente","vente.update");
App::get("vente/:id","vente.get")->avec("id","[0-9]+");
App::get("vente","vente.gets");
App::post("eliminer-vente","vente.eliminer");
App::post("vente/confirmerElimination","vente.confimerElimination");

App::get("vente/get-motif-elimination","vente.getMotifElimination");
App::post("vente/add-motif-elimination","vente.addMotifElimination");
App::put("vente/update-motif-elimination","vente.updateMotifElimination");
App::delete("vente/delete-motif/:id","vente.deleteMotif")->avec("id","[0-9]+");
App::put("payer-ticket/:id","vente.payerTicket")->avec("id","[0-9]+");
App::get("vente/total-vente","vente.totalVente");
App::get("vente/total-fiche-eliminer","vente.totalFicheEliminer");

//fin vente

//Tirage
App::post("tirage","tirage.add");
App::put("tirage","tirage.update");
App::get("tirage/:id","tirage.get")->avec("id","[0-9]+");
App::get("tirage","tirage.gets");
App::delete("tirage/:id","tirage.delete")->avec("id","[0-9]+");
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
//fin lot gagnants

//pos
App::post("pos","pos.add");
App::put("pos","pos.update");
App::get("pos/:id","pos.get")->avec("id","[0-9]+");
App::get("pos","pos.gets");
App::delete("pos/:id","pos.delete")->avec("id","[0-9]+");
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
//departement



