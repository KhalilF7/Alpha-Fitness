/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package GUI;

import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.control.Button;

/**
 * FXML Controller class
 *
 * @author user
 */
public class GestionProduitController implements Initializable {

    @FXML
    private Button btnCategories;
    @FXML
    private Button btnStocks;
    @FXML
    private Button btnProduits;
    @FXML
    private Button btnListProduit;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    

    @FXML
    private void GererCategories(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("GUICategorie.fxml"));
        Parent root = loader.load();
        btnCategories.getScene().setRoot(root);
        
    }

    @FXML
    private void GererStocks(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("GUIStock.fxml"));
        Parent root = loader.load();
        btnStocks.getScene().setRoot(root);
    }

    @FXML
    private void GererProduits(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("GUIProduit.fxml"));
        Parent root = loader.load();
        btnProduits.getScene().setRoot(root);
    }

    @FXML
    private void Produits(ActionEvent event) throws IOException {
        //FXMLLoader loader = new FXMLLoader(getClass().getResource("GUIListeProduits.fxml"));
        FXMLLoader loader = new FXMLLoader(getClass().getResource("GUIListeProduitsAVendre.fxml"));
        Parent root = loader.load();
        btnListProduit.getScene().setRoot(root);
    }
    
}
