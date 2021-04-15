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
public class Stock {
    private int id;
    private int idProduit;
    private Date dateEntree;
    private int quantite;

    public Stock(int id, int idProduit, Date dateEntree, int quantite) {
        this.id = id;
        this.idProduit = idProduit;
        this.dateEntree = dateEntree;
        this.quantite = quantite;
    }

    public Stock(int idProduit, Date dateEntree, int quantite) {
        this.idProduit = idProduit;
        this.dateEntree = dateEntree;
        this.quantite = quantite;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getIdProduit() {
        return idProduit;
    }

    public void setIdProduit(int idProduit) {
        this.idProduit = idProduit;
    }

    public Date getDateEntree() {
        return dateEntree;
    }

    public void setDateEntree(Date dateEntree) {
        this.dateEntree = dateEntree;
    }

    public int getQuantite() {
        return quantite;
    }

    public void setQuantite(int quantite) {
        this.quantite = quantite;
    }

    @Override
    public String toString() {
        return "Stock{" + "id=" + id + ", idProduit=" + idProduit + ", dateEntree=" + dateEntree + ", quantite=" + quantite + '}';
    }


}