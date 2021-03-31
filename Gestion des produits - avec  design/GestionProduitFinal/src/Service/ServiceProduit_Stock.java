/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Service;

import Entite.Produit_Stock;
import Utils.DataSource;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;

/**
 *
 * @author user
 */
public class ServiceProduit_Stock {

    Connection cnx = DataSource.getInstance().getConnection();

    public ObservableList<Produit_Stock> afficher() {
        ObservableList<Produit_Stock> list = FXCollections.observableArrayList();

        try {
            String requete = "select p.nom,s.dateentree,s.quantite from produit p INNER JOIN stock s where p.id= s.idproduit";
            //select * from produit p, stock s where p.id= s.idproduit
            PreparedStatement st = cnx.prepareStatement(requete);
            ResultSet rs = st.executeQuery(requete);

            while (rs.next()) {
                list.add(new Produit_Stock(rs.getString(1), rs.getDate(2), rs.getInt(3)));
            }

        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }

        return list;
    }
    
    public ObservableList<Produit_Stock> afficherTous() {
        ObservableList<Produit_Stock> list = FXCollections.observableArrayList();

        try {
            String requete = "select p.nom,p.categorie,p.prix,s.quantite,p.imgproduit from produit p INNER JOIN stock s where p.id= s.idproduit";
            //select * from produit p, stock s where p.id= s.idproduit
            PreparedStatement st = cnx.prepareStatement(requete);
            ResultSet rs = st.executeQuery(requete);

            while (rs.next()) {
                list.add(new Produit_Stock(rs.getString(1), rs.getString(2), rs.getDouble(3), rs.getInt(4),rs.getString(5)));
            }

        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }

        return list;
    }
    public ObservableList<Produit_Stock> afficherPDF() {
        ObservableList<Produit_Stock> list = FXCollections.observableArrayList();

        try {
            String requete = "select p.nom,p.categorie,p.prix,s.quantite from produit p INNER JOIN stock s where p.id= s.idproduit order by p.categorie";
            //select * from produit p, stock s where p.id= s.idproduit
            PreparedStatement st = cnx.prepareStatement(requete);
            ResultSet rs = st.executeQuery(requete);

            while (rs.next()) {
                list.add(new Produit_Stock(rs.getString(1), rs.getString(2), rs.getDouble(3), rs.getInt(4),rs.getString(5)));
            }

        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }

        return list;
    }
    
    public ObservableList<Produit_Stock> triCategorie(String c) {
        ObservableList<Produit_Stock> produits = FXCollections.observableArrayList();
        String requete = "select p.nom,p.categorie,p.prix,s.quantite,p.imgproduit from produit p INNER JOIN stock s where p.categorie= '"+c+"' AND p.id=s.idproduit";
        try {
            PreparedStatement pst = cnx.prepareStatement(requete);
            ResultSet rs = pst.executeQuery();
            while (rs.next()) {

                produits.add(new Produit_Stock(rs.getString(1), rs.getString(2), rs.getDouble(3), rs.getInt(4),rs.getString(5)));
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return produits;
    }
    
    public ObservableList<Produit_Stock> triNom() {
        ObservableList<Produit_Stock> produits = FXCollections.observableArrayList();
        String requete = "select p.nom,p.categorie,p.prix,s.quantite,p.imgproduit from produit p INNER JOIN stock s where p.id=s.idproduit ORDER BY p.nom";
        try {
            PreparedStatement pst = cnx.prepareStatement(requete);
            ResultSet rs = pst.executeQuery();
            while (rs.next()) {

                produits.add(new Produit_Stock(rs.getString(1), rs.getString(2), rs.getDouble(3), rs.getInt(4),rs.getString(5)));
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return produits;
    }
    
    public ObservableList<Produit_Stock> triCategorie() {
        ObservableList<Produit_Stock> produits = FXCollections.observableArrayList();
        String requete = "select p.nom,p.categorie,p.prix,s.quantite,p.imgproduit from produit p INNER JOIN stock s where p.id=s.idproduit ORDER BY p.categorie";
        try {
            PreparedStatement pst = cnx.prepareStatement(requete);
            ResultSet rs = pst.executeQuery();
            while (rs.next()) {

                produits.add(new Produit_Stock(rs.getString(1), rs.getString(2), rs.getDouble(3), rs.getInt(4),rs.getString(5)));
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return produits;
    }
    
    public ObservableList<Produit_Stock> triPrix() {
        ObservableList<Produit_Stock> produits = FXCollections.observableArrayList();
        String requete = "select p.nom,p.categorie,p.prix,s.quantite,p.imgproduit from produit p INNER JOIN stock s where p.id=s.idproduit ORDER BY p.prix";
        try {
            PreparedStatement pst = cnx.prepareStatement(requete);
            ResultSet rs = pst.executeQuery();
            while (rs.next()) {

                produits.add(new Produit_Stock(rs.getString(1), rs.getString(2), rs.getDouble(3), rs.getInt(4),rs.getString(5)));
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return produits;
    }
    
    public ObservableList<Produit_Stock> triQuantite() {
        ObservableList<Produit_Stock> produits = FXCollections.observableArrayList();
        String requete = "select p.nom,p.categorie,p.prix,s.quantite,p.imgproduit from produit p INNER JOIN stock s where p.id=s.idproduit ORDER BY s.quantite";
        try {
            PreparedStatement pst = cnx.prepareStatement(requete);
            ResultSet rs = pst.executeQuery();
            while (rs.next()) {

                produits.add(new Produit_Stock(rs.getString(1), rs.getString(2), rs.getDouble(3), rs.getInt(4),rs.getString(5)));
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return produits;
    }
}
