/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Entite;

import java.sql.Date;


/**
 *
 * @author user
 */
public class Produit_Stock {
    private String produit;
    private String categorie;
    private double prix;
    private Date dateAjout;
    private int quantite;
    private String image;

    public Produit_Stock() {
    }

    public Produit_Stock(String produit, int quantite) {
        this.produit = produit;
        this.quantite = quantite;
    }

    public Produit_Stock(String produit, Date dateAjout, int quantite) {
        this.produit = produit;
        this.dateAjout = dateAjout;
        this.quantite = quantite;
    }

    public Produit_Stock(String produit, String categorie, double prix, int quantite, String image) {
        this.produit = produit;
        this.categorie = categorie;
        this.prix = prix;
        this.quantite = quantite;
        this.image = image;
    }

    public String getProduit() {
        return produit;
    }

    public void setProduit(String produit) {
        this.produit = produit;
    }

    public Date getDateAjout() {
        return dateAjout;
    }

    public void setDateAjout(Date dateAjout) {
        this.dateAjout = dateAjout;
    }

    public int getQuantite() {
        return quantite;
    }

    public void setQuantite(int quantite) {
        this.quantite = quantite;
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

    public void setPrix(int prix) {
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
        return "Produit_Stock{" + "produit=" + produit + ", categorie=" + categorie + ", prix=" + prix + ", dateAjout=" + dateAjout + ", quantite=" + quantite + ", image=" + image + '}';
    }
    
}
