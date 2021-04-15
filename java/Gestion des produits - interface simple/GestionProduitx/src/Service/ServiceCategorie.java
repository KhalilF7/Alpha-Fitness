/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Service;

import Entite.Categorie;
import Entite.Produit;
import Utils.DataSource;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;

/**
 *
 * @author user
 */
public class ServiceCategorie implements IService<Categorie> {

    Connection cnx = DataSource.getInstance().getConnection();

    @Override
    public void ajouter(Categorie t) {
        try {
            String requete = "INSERT INTO categorie (titre) VALUES (?)";
            PreparedStatement st = cnx.prepareStatement(requete);
            st.setString(1, t.getTitre());
            st.executeUpdate();
            System.out.println("Categorie ajoutée !");

        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
    }

    @Override
    public ObservableList<Categorie> afficher() {
        ObservableList<Categorie> list = FXCollections.observableArrayList();

        try {
            String requete = "SELECT * FROM categorie";
            PreparedStatement st = cnx.prepareStatement(requete);
            ResultSet rs = st.executeQuery();
            while (rs.next()) {
                list.add(new Categorie(rs.getInt(1), rs.getString(2)));
            }

        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }

        return list;
    }

    @Override
    public void modifier(Categorie t) {
        if (exist(t)) {
            try {
                String requete = "UPDATE categorie SET titre=? WHERE id=?";
                PreparedStatement st = cnx.prepareStatement(requete);
                st.setInt(2, t.getIdCat());
                st.setString(1, t.getTitre());
                System.out.println("Categorie modifiée !");

            } catch (SQLException ex) {
                System.err.println(ex.getMessage());
            }
        } else {
            System.out.println("Categorie n'existe pas !");
        }
    }

    @Override
    public void suprimer(Categorie t) {
        //if (exist(getById(id))) {
            try {
                Statement ste = cnx.createStatement();
                String requetedelete = "delete from categorie where id=" + t.getIdCat();
                ste.execute(requetedelete);
                /*String requete = "DELETE FROM categorie WHERE id="+id;
                PreparedStatement st = cnx.prepareStatement(requete);
                ResultSet rs = st.executeQuery();*/
                System.out.println("Categorie supprimée !");

            } catch (SQLException ex) {
                System.err.println(ex.getMessage());
            }
        /*} else {
            System.out.println("Categorie n'existe pas !");
        }*/
    }

    @Override
    public Categorie getById(int id) {
        try {
            String query = "select * from categorie where id=" + id;
            PreparedStatement pst;

            pst = cnx.prepareStatement(query);

            ResultSet rs = pst.executeQuery();
            while (rs.next()) {
                Categorie a = new Categorie(rs.getInt(1), rs.getString(2));
                return a;
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return null;
    }

    @Override
    public Boolean exist(Categorie t) {
        
            return (t != null);
    }
    
    public Categorie getByTitre(String titre) {
        try {
            String query = "select * from categorie where titre ='" + titre + "'";
            PreparedStatement pst;

            pst = cnx.prepareStatement(query);

            ResultSet rs = pst.executeQuery();
            while (rs.next()) {
                Categorie a = new Categorie(rs.getInt(1), rs.getString(2));
                return a;
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return null;
    }

public void modifier1(int id, String titre) {
            try {
                String requete = "UPDATE categorie SET titre='"+titre+"' WHERE id="+id;
                Statement st = cnx.createStatement();
                st.executeUpdate(requete);
                System.out.println("Categorie modifiée !");

            } catch (SQLException ex) {
                System.err.println(ex.getMessage());
            }
    }

}
