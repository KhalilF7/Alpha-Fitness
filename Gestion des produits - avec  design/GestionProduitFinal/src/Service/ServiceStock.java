/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Service;

import Entite.Stock;
import Utils.DataSource;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
import java.sql.*;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;

/**
 *
 * @author user
 */
public class ServiceStock implements IService<Stock> {

    Connection cnx = DataSource.getInstance().getConnection();

    @Override
    public void ajouter(Stock t) {
        try {
            String requete = "INSERT INTO stock (idproduit,dateentree,quantite) VALUES(?,?,?)";
            PreparedStatement st = cnx.prepareStatement(requete);
            st.setInt(1, t.getIdProduit());
            st.setDate(2, new Date(t.getDateEntree().getTime()));
            st.setInt(3, t.getQuantite());
            st.executeUpdate();
            System.out.println("Stock ajoutée !");

        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
    }

    @Override
    public ObservableList<Stock> afficher() {
        ObservableList<Stock> list = FXCollections.observableArrayList();

        try {
            String requete = "select p.nom,s.dateentree,s.quantite from produit p INNER JOIN stock s where p.id= s.idproduit";
            //select * from produit p, stock s where p.id= s.idproduit
            PreparedStatement st = cnx.prepareStatement(requete);
            ResultSet rs = st.executeQuery(requete);

            while (rs.next()) {
                list.add(new Stock(rs.getInt(1), rs.getInt(2), rs.getDate(3), rs.getInt(4)));
            }

        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }

        return list;
    }

    @Override
    public void modifier(Stock t) {
        if (exist(t)) {
            try {
                String requete = "UPDATE stock SET idproduit=?,dateentree=?,quantite=? WHERE id=?";
                PreparedStatement pst = cnx.prepareStatement(requete);
                pst.setInt(4, t.getId());
                pst.setInt(1, t.getIdProduit());
                pst.setDate(2, new java.sql.Date(t.getDateEntree().getTime()));
                pst.setInt(3, t.getQuantite());

                pst.executeUpdate();
                System.out.println("Stock modifié !");

            } catch (SQLException ex) {
                System.err.println(ex.getMessage());
            }
        } else {
            System.out.println("Stock n'existe pas !");
        }
    }

    @Override
    public void suprimer(Stock t) {
        //if (exist(getById(id))) {
            try {
                Statement ste = cnx.createStatement();
                String requetedelete = "delete from stock where id=" + t.getId();
                ste.execute(requetedelete);
                System.out.println("Stock supprimé !");

            } catch (SQLException ex) {
                System.err.println(ex.getMessage());
            }
        //} else {
          //  System.out.println("Stock n'existe pas !");
        //}
    }

    @Override
    public Stock getById(int id) {
        try {
            String query = "select * from stock where id=" + id;
            PreparedStatement pst;

            pst = cnx.prepareStatement(query);

            ResultSet rs = pst.executeQuery();
            while (rs.next()) {
                Stock a = new Stock(rs.getInt(1), rs.getInt(2), rs.getDate(3), rs.getInt(4));
                return a;
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return null;
    }

    @Override
    public Boolean exist(Stock t) {
        return t != null;
    }

    public Boolean produitExist(int id) {
        List<Integer> listId = new ArrayList();
        try {
            String query = "select idproduit from stock where idproduit="+id;
            PreparedStatement pst;

            pst = cnx.prepareStatement(query);

            ResultSet rs = pst.executeQuery();
            while (rs.next()) {
                listId.add(rs.getInt(1));
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return !listId.isEmpty();
    }
    
    public void mettreAJourQte(int id, int quantite) {
        try {
            String requete = "UPDATE stock SET quantite=quantite+" + quantite + " WHERE idproduit=" + id;
            PreparedStatement pst = cnx.prepareStatement(requete);
            pst.executeUpdate();
            System.out.println("Produit modifiée !");

        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
    }

    public Stock getByProduit(int id) {
        try {
            String query = "select * from stock where idproduit=" + id;
            PreparedStatement pst;

            pst = cnx.prepareStatement(query);

            ResultSet rs = pst.executeQuery();
            while (rs.next()) {
                Stock a = new Stock(rs.getInt(1), rs.getInt(2), rs.getDate(3), rs.getInt(4));
                return a;
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return null;
    }
    
    public void modifier1(int id, int idproduit, Date dateajout, int quantite) {
        try {
            String requete = "UPDATE stock SET idproduit=" + idproduit + ", dateentree='" + dateajout + "' , quantite=" + quantite + " WHERE id=" + id;
            PreparedStatement pst = cnx.prepareStatement(requete);
            pst.executeUpdate();
            System.out.println("Stock modifiée !");

        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
    }
    
}
