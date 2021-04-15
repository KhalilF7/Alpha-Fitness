/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Entite;

import java.io.InputStream;
import java.sql.Blob;

/**
 *
 * @author user
 */
public class Produit {
    private int id;
    private String nom;
    private String categorie;
    private double prix;
    private String image; 

    public Produit(int id, String nom, String categorie, double prix, String image) {
        this.id = id;
        this.nom = nom;
        this.categorie = categorie;
        this.prix = prix;
        this.image = image;
    }

    public Produit(String nom, String categorie, double prix, String image) {
        this.nom = nom;
        this.categorie = categorie;
        this.prix = prix;
        this.image = image;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public String getCategorie() {
        return categorie;
    }

    public void setCategorie(String categorie) {
        this.categorie = categorie;
    }

    public double getPrix() {
        return prix;
    }

    public void setPrix(double prix) {
        this.prix = prix;
    }

    public String getImage() {
        return image;
    }

    public void setImage(String image) {
        this.image = image;
    }

    @Override
    public String toString() {
        return "Produit{" + "id=" + id + ", nom=" + nom + ", categorie=" + categorie + ", prix=" + prix + ", image=" + image + '}';
    }

    
}
