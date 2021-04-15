/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package GUI;

import Entite.Categorie;
import Service.ServiceCategorie;
import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.control.Button;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;
import javax.swing.JOptionPane;

/**
 * FXML Controller class
 *
 * @author user
 */
public class CategorieController implements Initializable {

    @FXML
    private TextField tfTitre;
    @FXML
    private Button btnAjouter;
    @FXML
    private TableView<Categorie> listCategories;
    @FXML
    private Button btnModifier;
    @FXML
    private Button btnSupprimer;
    @FXML
    private TableColumn<Categorie, String> colCategorie;

    ObservableList<Categorie> listC;
    ServiceCategorie sc = new ServiceCategorie();
    int index = -1;
    @FXML
    private Button btnHome;
    @FXML
    private Button btnAnnuler;
    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
        colCategorie.setCellValueFactory(new PropertyValueFactory<>("titre"));
        listC = sc.afficher();
        listCategories.setItems(listC);
    }

    @FXML
    private void AjouterCategorie(ActionEvent event) {

        /*if (tfTitre.getText() == null) {
            JOptionPane.showMessageDialog(null, "Saisir un titre de catégorie !");
        } else {*/
        sc.ajouter(new Categorie(tfTitre.getText()));
        JOptionPane.showMessageDialog(null, "Category added successfully !");
        listC = sc.afficher();
        listCategories.setItems(listC);
        tfTitre.setText("");
        //}
    }

    //verifier les inputs
    private boolean verifInputs() {
        if (tfTitre.getText() == null) {
            return false;
        } else {
            try {
                tfTitre.getText();
                return true;
            } catch (Exception x) {
                return false;
            }
        }
    }

    @FXML
    private void ModifierCategorie(ActionEvent event) {
        String c = listCategories.getSelectionModel().getSelectedItem().getTitre();
        sc.modifier1(sc.getByTitre(c).getIdCat(), tfTitre.getText());
        JOptionPane.showMessageDialog(null, "Category successfully edited !");
        listC = sc.afficher();
        listCategories.setItems(listC);
        tfTitre.setText("");
    }

    
    @FXML
    private void SupprimerCategorie(ActionEvent event) {
        //if (!tfId.getText().equals("")) {
            sc.suprimer(sc.getByTitre(tfTitre.getText()));
            JOptionPane.showMessageDialog(null, "Category successfully deleted !");
        //}
        listC = sc.afficher();
        listCategories.setItems(listC);
        tfTitre.setText("");
    }


    @FXML
    private void getSelect(javafx.scene.input.MouseEvent event) {
        index = listCategories.getSelectionModel().getSelectedIndex();
        if(index<= -1)
        {
            return;
        }
        
        tfTitre.setText(colCategorie.getCellData(index));
    }
/*
    @FXML
    private void categorie(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("GUICategorie.fxml"));
        Parent root = loader.load();
        tfId.getScene().setRoot(root);
    }

    @FXML
    private void produit(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("GUIProduit.fxml"));
        Parent root = loader.load();
        tfId.getScene().setRoot(root);
    }

    @FXML
    private void stock(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("GUIStock.fxml"));
        Parent root = loader.load();
        tfId.getScene().setRoot(root);
    }
*/
    @FXML
    private void accueil(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("GestionProduit.fxml"));
        Parent root = loader.load();
        btnHome.getScene().setRoot(root);
    }

    @FXML
    private void annuler(ActionEvent event) {
        tfTitre.setText("");
    }

}
