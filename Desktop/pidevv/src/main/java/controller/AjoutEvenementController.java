package controller;

import entities.Evenement;
import entities.Sponsor;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.Button;
import javafx.scene.control.ComboBox;
import javafx.scene.control.DatePicker;
import javafx.scene.control.ListCell;
import javafx.scene.control.TextField;
import javafx.stage.Stage;
import services.ServiceEvenement;
import services.ServiceSponsor;

import java.io.IOException;
import java.sql.SQLException;
import java.time.LocalDate;
import java.util.List;

public class AjoutEvenementController {

    @FXML
    private TextField nomField;

    @FXML
    private TextField typeField;

    @FXML
    private DatePicker dateDebutPicker;

    @FXML
    private DatePicker dateFinPicker;

    @FXML
    private TextField lieuField;

    @FXML
    private TextField budgetField;

    @FXML
    private TextField descriptionField;

    @FXML
    private ComboBox<Sponsor> sponsorComboBox;

    @FXML
    private Button ajouterButton;

    @FXML
    private Button annulerButton;


    @FXML
    private Button handleBackButton;


    @FXML
    private Button btnBack;




    private final ServiceEvenement serviceEvenement;
    private final ServiceSponsor serviceSponsor;

    public AjoutEvenementController() {
        serviceEvenement = new ServiceEvenement();
        serviceSponsor = new ServiceSponsor();
    }

    @FXML
    public void initialize() {

        remplirComboBoxSponsors();


        ajouterButton.setOnAction(event -> ajouterEvenement());
        annulerButton.setOnAction(event -> fermerFenetre());
    }

    private void remplirComboBoxSponsors() {
        try {

            List<Sponsor> sponsors = serviceSponsor.afficher();


            ObservableList<Sponsor> sponsorList = FXCollections.observableArrayList(sponsors);


            sponsorComboBox.setItems(sponsorList);


            sponsorComboBox.setCellFactory(param -> new ListCell<Sponsor>() {
                @Override
                protected void updateItem(Sponsor sponsor, boolean empty) {
                    super.updateItem(sponsor, empty);
                    if (empty || sponsor == null) {
                        setText(null);
                    } else {
                        setText(sponsor.getNom());
                    }
                }
            });

            sponsorComboBox.setButtonCell(new ListCell<Sponsor>() {
                @Override
                protected void updateItem(Sponsor sponsor, boolean empty) {
                    super.updateItem(sponsor, empty);
                    if (empty || sponsor == null) {
                        setText(null);
                    } else {
                        setText(sponsor.getNom());
                    }
                }
            });

        } catch (SQLException e) {
            afficherAlerte("Erreur", "Une erreur s'est produite lors du chargement des sponsors : " + e.getMessage());
        }
    }

    @FXML
    private void handleBackButton(ActionEvent event) {
        try {

            FXMLLoader loader = new FXMLLoader(getClass().getResource("/afficherevenement.fxml"));
            Parent root = loader.load();


            Scene scene = new Scene(root);


            Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow();
            stage.setScene(scene);
            stage.show();
        } catch (IOException e) {
            System.err.println("Erreur lors du chargement de l'interface d'affichage des sponsors : " + e.getMessage());
        }
    }




    private void ajouterEvenement() {
        try {
            String nom = nomField.getText();
            String type = typeField.getText();
            LocalDate dateDebut = dateDebutPicker.getValue();
            LocalDate dateFin = dateFinPicker.getValue();
            String lieu = lieuField.getText();
            double budget = Double.parseDouble(budgetField.getText());
            String description = descriptionField.getText();
            Sponsor selectedSponsor = sponsorComboBox.getValue();

            if (nom.isEmpty() || type.isEmpty() || dateDebut == null || dateFin == null || lieu.isEmpty() || description.isEmpty() || selectedSponsor == null) {
                afficherAlerte("Erreur", "Veuillez remplir tous les champs.");
                return;
            }

            Evenement evenement = new Evenement();
            evenement.setNom(nom);
            evenement.setType(type);
            evenement.setDate_debut(java.sql.Date.valueOf(dateDebut));
            evenement.setDate_fin(java.sql.Date.valueOf(dateFin));
            evenement.setLieu(lieu);
            evenement.setBudget(new java.math.BigDecimal(budget));
            evenement.setDescription(description);
            evenement.setId_sp(selectedSponsor.getId_sp());


            serviceEvenement.ajouter(evenement);


            afficherAlerte("Succès", "L'événement a été ajouté avec succès.");


            resetFields();

        } catch (NumberFormatException e) {
            afficherAlerte("Erreur", "Le budget doit être un nombre valide.");
        } catch (SQLException e) {
            afficherAlerte("Erreur", "Une erreur s'est produite lors de l'ajout de l'événement : " + e.getMessage());
        }
    }
    private void resetFields() {
        nomField.clear();
        typeField.clear();
        dateDebutPicker.setValue(null);
        dateFinPicker.setValue(null);
        lieuField.clear();
        budgetField.clear();
        descriptionField.clear();
        sponsorComboBox.setValue(null);
    }

    private void fermerFenetre() {

        Stage stage = (Stage) annulerButton.getScene().getWindow();
        stage.close();
    }

    private void afficherAlerte(String titre, String message) {
        Alert alert = new Alert(Alert.AlertType.INFORMATION);
        alert.setTitle(titre);
        alert.setHeaderText(null);
        alert.setContentText(message);
        alert.showAndWait();
    }
}
