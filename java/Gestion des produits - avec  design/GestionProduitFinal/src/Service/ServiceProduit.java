/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Service;

import Entite.Produit;
import java.sql.*;
import Utils.DataSource;
import java.util.ArrayList;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javax.swing.JOptionPane;

/**
 *
 * @author user
 */
public class ServiceProduit implements IService<Produit> {

    private Connection con = DataSource.getInstance().getConnection();
    String lienImage = null;

    @Override
    public void ajouter(Produit t) {
        
            try {
                String requete = "INSERT INTO produit (nom, categorie, prix, imgproduit) VALUES (?,?,?,?)";
                PreparedStatement pst = con.prepareStatement(requete);
                pst.setString(1, t.getNom());
                pst.setString(2, t.getCategorie());
                pst.setDouble(3, t.getPrix());
                //InputStream img = new FileInputStream(new File());
                pst.setString(4, t.getImage());

                pst.executeUpdate();
                JOptionPane.showMessageDialog(null, "Product added successfully !");

            } catch (SQLException ex) {
                System.err.println(ex.getMessage());
            }
        
    }

    @Override
    public ObservableList<Produit> afficher() {
        ObservableList<Produit> list = FXCollections.observableArrayList();

        try {
            String requete = "SELECT * FROM produit";
            PreparedStatement pst = con.prepareStatement(requete);
            ResultSet rs = pst.executeQuery();
            while (rs.next()) {
                list.add(new Produit(rs.getInt(1), rs.getString(2), rs.getString(3), rs.getDouble(4), rs.getString(5)));
            }

        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }

        return list;
    }

    @Override
    public void modifier(Produit t) {
        if (exist(t)) {
            try {
                String requete = "UPDATE produit SET nom=?,categorie=?,prix=?,quantite=?,imgproduit=? WHERE id=?";
                PreparedStatement pst = con.prepareStatement(requete);
                pst.setInt(5, t.getId());
                pst.setString(1, t.getNom());
                pst.setString(2, t.getCategorie());
                pst.setDouble(3, t.getPrix());
                pst.setString(4, t.getImage());
                pst.executeUpdate();
                System.out.println("Produit modifiée !");

            } catch (SQLException ex) {
                System.err.println(ex.getMessage());
            }
        } else {
            System.out.println("Produit n'existe pas !");
        }
    }

    @Override
    public void suprimer(Produit t) {
        //if (exist(getById(id))) {
        try {
            Statement ste = con.createStatement();
            String requetedelete = "delete from produit where id=" + t.getId();
            ste.execute(requetedelete);
            System.out.println("Produit supprimée !");

        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
        /*} else {
            System.out.println("Produit n'existe pas !");
        }*/
    }

    
public ArrayList<Produit> RechercheNom(String nom) {

        ArrayList<Produit> produits = new ArrayList<>();
        String requete = "select * from produit where nom ='" + nom + "'";
        try {
            PreparedStatement pst = con.prepareStatement(requete);
            ResultSet rs = pst.executeQuery();
            while (rs.next()) {

                produits.add(new Produit(rs.getInt(1), rs.getString(2), rs.getString(3), rs.getDouble(4), rs.getString(5)));
            }
        } catch (SQLException ex) {
            System.out.println("Erreur lors d'extraction des données \n" + ex.getMessage());
        }
        return produits;
    }
/*
    public ArrayList<Produit> triNom() {
        ArrayList<Produit> produits = new ArrayList<>();
        String requete = "select * from produit ORDER BY nom DESC";
        try {
            PreparedStatement pst = con.prepareStatement(requete);
            ResultSet rs = pst.executeQuery();
            while (rs.next()) {

                produits.add(new Produit(rs.getInt(1), rs.getString(2), rs.getInt(3), rs.getInt(4), rs.getInt(5)));
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return produits;
    }

    public ArrayList<Produit> triQuqntite() {
        ArrayList<Produit> produits = new ArrayList<>();
        String requete = "select * from produit ORDER BY quantite DESC";
        try {
            PreparedStatement pst = con.prepareStatement(requete);
            ResultSet rs = pst.executeQuery();
            while (rs.next()) {

                produits.add(new Produit(rs.getInt(1), rs.getString(2), rs.getInt(3), rs.getInt(4), rs.getInt(5)));
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return produits;
    }

    public ArrayList<Produit> triPrix() {
        ArrayList<Produit> produits = new ArrayList<>();
        String requete = "select * from produit ORDER BY prix DESC";
        try {
            PreparedStatement pst = con.prepareStatement(requete);
            ResultSet rs = pst.executeQuery();
            while (rs.next()) {

                produits.add(new Produit(rs.getInt(1), rs.getString(2), rs.getInt(3), rs.getInt(4), rs.getInt(5)));
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return produits;
    }

    public int nombre() {

        int i = 0;
        String requete = "SELECT COUNT(*) as nbr FROM produit";

        try {
            Statement st = con.createStatement();
            ResultSet rs = st.executeQuery(requete);

            while (rs.next()) {

                i = rs.getInt("nbr");

            }
        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
        return i;
    }
     */
    @Override
    public Produit getById(int id) {
        try {
            String query = "select * from produit where id=" + id;
            PreparedStatement pst;

            pst = con.prepareStatement(query);

            ResultSet rs = pst.executeQuery();
            while (rs.next()) {
                Produit a = new Produit(rs.getInt(1), rs.getString(2), rs.getString(3), rs.getDouble(4), rs.getString(5));
                return a;
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return null;
    }

    @Override
    public Boolean exist(Produit t) {
        return getById(t.getId()) != null;
    }

    public Produit getByNom(String nom) {
        try {
            String query = "select * from produit where nom='" + nom + "'";
            PreparedStatement pst;

            pst = con.prepareStatement(query);

            ResultSet rs = pst.executeQuery();
            while (rs.next()) {
                Produit a = new Produit(rs.getInt(1), rs.getString(2), rs.getString(3), rs.getDouble(4), rs.getString(5));
                return a;
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return null;
    }

    public void modifier1(int id, String nom, String categorie, double prix, String imgproduit) {
        try {
            String requete = "UPDATE produit SET nom='" + nom + "',categorie='" + categorie + "',prix=" + prix + ",imgproduit='" + imgproduit + "' WHERE id=" + id;
            PreparedStatement pst = con.prepareStatement(requete);
            pst.executeUpdate();
            System.out.println("Produit modifiée !");

        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
    }
    
    public Boolean produitExist(String nom) {
        
        if(RechercheNom(nom).isEmpty())
            return false;
        else
            return true;
    }
}
