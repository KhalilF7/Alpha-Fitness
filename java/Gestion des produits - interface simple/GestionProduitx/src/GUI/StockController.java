/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package GUI;

import Entite.Produit_Stock;
import Entite.Stock;
import Service.ServiceProduit;
import Service.ServiceProduit_Stock;
import Service.ServiceStock;
import Utils.DataSource;
import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.Date;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ResourceBundle;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.control.Button;
import javafx.scene.control.ComboBox;
import javafx.scene.control.DatePicker;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.input.MouseEvent;
import javax.swing.JOptionPane;

/**
 * FXML Controller class
 *
 * @author user
 */
public class StockController implements Initializable {

    @FXML
    private Button btnHome;
    @FXML
    private TextField tfQuantite;
    @FXML
    private ComboBox<String> cbProduit;
    @FXML
    private Button btnAjouter;
    @FXML
    private Button btnModifier;
    @FXML
    private Button btnSupprimer;
    @FXML
    private DatePicker DpDateAjout;

    ObservableList<Produit_Stock> listS;

    ServiceStock ss = new ServiceStock();
    private Connection con = DataSource.getInstance().getConnection();
    int index = -1;
    ObservableList<String> options = FXCollections.observableArrayList();
    @FXML
    private TableView<Produit_Stock> listStock;
    @FXML
    private TableColumn<Produit_Stock, String> colProduit;
    @FXML
    private TableColumn<Produit_Stock, Date> colDate;
    @FXML
    private TableColumn<Produit_Stock, Integer> colQuantite;
    @FXML
    private Button btnAnnuler;
    ServiceProduit sp = new ServiceProduit();
    ServiceProduit_Stock sps = new ServiceProduit_Stock();

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
        colProduit.setCellValueFactory(new PropertyValueFactory<>("produit"));
        colDate.setCellValueFactory(new PropertyValueFactory<>("dateAjout"));
        colQuantite.setCellValueFactory(new PropertyValueFactory<>("quantite"));

        listS = sps.afficher();
        listStock.setItems(listS);

        remplirListProduits();
        cbProduit.setItems(options);
    }

    @FXML
    private void accueil(ActionEvent event) throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("GestionProduit.fxml"));
        Parent root = loader.load();
        btnHome.getScene().setRoot(root);
    }

    private void remplirListProduits() {

        try {
            String requete = "Select nom from produit";
            ResultSet rs;
            PreparedStatement pst = con.prepareStatement(requete);
            rs = pst.executeQuery();
            while (rs.next()) {
                options.add(rs.getString("nom"));
            }
            pst.close();
            rs.close();
        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
    }

    //verifier les inputs
    private boolean verifInputs() {
        if (cbProduit.getSelectionModel().getSelectedItem() == null || tfQuantite.getText() == null) {
            return false;
        } else {
            try {
                cbProduit.getSelectionModel().getSelectedItem();
                return true;
            } catch (Exception x) {
                return false;
            }
        }
    }

    @FXML
    private void AjouterStock(ActionEvent event) {
        /*int y = (DpDateAjout.getValue().getYear() % 100) + 100;
        int m = DpDateAjout.getValue().getMonthValue() - 1;
        int day = DpDateAjout.getValue().getDayOfMonth();
        Date d = new java.sql.Date(y, m, day);*/
        if (!ss.produitExist(sp.getByNom(cbProduit.getSelectionModel().getSelectedItem()).getId())) {
            ss.ajouter(new Stock(sp.getByNom(cbProduit.getSelectionModel().getSelectedItem()).getId(), Date.valueOf(DpDateAjout.getValue()), Integer.parseInt(tfQuantite.getText())));
            JOptionPane.showMessageDialog(null, "Product successfully added to stock !");
        } else {
            int reponse = JOptionPane.showConfirmDialog(null, "Product already exists in stock \n Do you want to update its quantity ?", "Existing Product !", JOptionPane.YES_NO_OPTION, JOptionPane.QUESTION_MESSAGE);
            if (reponse == JOptionPane.YES_OPTION) {
                ss.mettreAJourQte(sp.getByNom(cbProduit.getSelectionModel().getSelectedItem()).getId(), Integer.parseInt(tfQuantite.getText()));
            }
        }
        listS = sps.afficher();
        listStock.setItems(listS);
        cbProduit.setValue("");
        DpDateAjout.setValue(null);
        tfQuantite.setText("");
    }

    @FXML
    private void ModifierStock(ActionEvent event) {
        int s = sp.getByNom(listStock.getSelectionModel().getSelectedItem().getProduit()).getId();
        int p = sp.getByNom(cbProduit.getSelectionModel().getSelectedItem()).getId();
        if ((!ss.produitExist(s)) || (s == p)) {
        ss.modifier1(ss.getByProduit(s).getId(), p, Date.valueOf(DpDateAjout.getValue()), Integer.parseInt(tfQuantite.getText()));
        JOptionPane.showMessageDialog(null, "Product successfully edited in stock !");
        } else {
            JOptionPane.showMessageDialog(null, "You cannot choose this item, it is already in stock ! \n Try to choose a different one !", "Product already exists in stock !", 1);
        }
        listS = sps.afficher();
        listStock.setItems(listS);
        cbProduit.setValue("");
        DpDateAjout.setValue(null);
        tfQuantite.setText("");
    }

    @FXML
    private void SupprimerStock(ActionEvent event) {
        ss.suprimer(ss.getByProduit(sp.getByNom(cbProduit.getSelectionModel().getSelectedItem()).getId()));
        JOptionPane.showMessageDialog(null, "Product successfully deleted from stock !");
        listS = sps.afficher();
        listStock.setItems(listS);
        cbProduit.setValue("");
        DpDateAjout.setValue(null);
        tfQuantite.setText("");
    }

    @FXML
    private void getSelect(MouseEvent event) {
        index = listStock.getSelectionModel().getSelectedIndex();
        if (index <= -1) {
            return;
        }

        cbProduit.setValue(colProduit.getCellData(index));
        DpDateAjout.setValue(colDate.getCellData(index).toLocalDate());
        tfQuantite.setText(colQuantite.getCellData(index).toString());
    }

    @FXML
    private void annuler(ActionEvent event) {

        cbProduit.setValue("");
        DpDateAjout.setValue(null);
        tfQuantite.setText("");
    }

}
