<?php
use app\DefaultApp\DefaultApp as App;
App::get("/", "default.index", "index");
App::post("/", "default.index","index_post");


//code jeux
App::post("code-jeux/add","codeJeux.add");
App::put("code-jeux/update","codeJeux.update")->avec("id","[0-9]+");
App::get("code-jeux/get/:id","codeJeux.get")->avec("id","[0-9]+");
App::get("code-jeux/gets","codeJeux.gets");
//fin code jeux


//client
App::post("client/add","client.add");
App::put("client/update","client.update")->avec("id","[0-9]+");
App::get("client/get/:id","client.get")->avec("id","[0-9]+");
App::get("client/gets","client.gets");
//fin client


//vendeur
App::post("vendeur/add","vendeur.add");
App::put("vendeur/update","vendeur.update")->avec("id","[0-9]+");
App::get("vendeur/get/:id","vendeur.get")->avec("id","[0-9]+");
App::get("vendeur/gets","vendeur.gets");
//fin vendeur


//vendeur
App::post("vente/add","vente.add");
App::put("vente/update","vente.update")->avec("id","[0-9]+");
App::get("vente/get/:id","vente.get")->avec("id","[0-9]+");
App::get("vente/gets","vente.gets");
App::delete("vente/eliminer","vente.eliminer");
App::delete("vente/confirmerElimination","vente.confimerElimination");

//fin vendeur




