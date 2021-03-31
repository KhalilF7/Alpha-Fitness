/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Entite;

/**
 *
 * @author user
 */
public class Categorie {
    private int idCtegorie;
    private String titre;

    public Categorie(int idCtegorie, String titre) {
        this.idCtegorie = idCtegorie;
        this.titre = titre;
    }

    public Categorie(String titre) {
        this.titre = titre;
    }
    public int getIdCat() {
        return idCtegorie;
    }
    public void setIdCat(int idCat) {
        this.idCtegorie = idCat;
    }

    public String getTitre() {
        return titre;
    }

    public void setTitre(String titre) {
        this.titre = titre;
    }

    @Override
    public String toString() {
        return "Categorie{" + "idCtegorie=" + idCtegorie + ", titre=" + titre + '}';
    }

    
}
