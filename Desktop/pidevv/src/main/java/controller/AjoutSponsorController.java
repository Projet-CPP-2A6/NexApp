package controller;

import entities.Sponsor;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Node;
import javafx.scene.control.Alert;
import javafx.scene.control.Button;
import javafx.scene.control.TextField;
import javafx.scene.layout.AnchorPane;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.stage.Stage;
import services.ServiceSponsor;

import java.io.IOException;
import java.sql.SQLException;

public class AjoutSponsorController {

    @FXML
    private TextField tf_nom; // Champ pour le nom du sponsor

    @FXML
    private TextField tf_type; // Champ pour le type du sponsor

    @FXML
    private TextField tf_telephone; // Champ pour le téléphone du sponsor

    @FXML
    private TextField tf_email; // Champ pour l'email du sponsor

    @FXML
    private Button btnAjouter;

    @FXML
    private Button btnBack;

    @FXML
    private AnchorPane ajoutsponsor;
    @FXML
    public void ajouterSponsor(ActionEvent actionEvent) {
        // Vérifications des champs de texte
        if (tf_nom.getText().isEmpty() || tf_type.getText().isEmpty() ||
                tf_telephone.getText().isEmpty() || tf_email.getText().isEmpty()) {

            // Afficher une alerte d'erreur si un champ est vide
            Alert alert = new Alert(Alert.AlertType.ERROR);
            alert.setTitle("Champs manquants");
            alert.setContentText("Veuillez remplir tous les champs !");
            alert.showAndWait();
            return;
        }

        // Vérification du format du numéro de téléphone
        if (!tf_telephone.getText().matches("\\d{8}")) {
            Alert alert = new Alert(Alert.AlertType.ERROR);
            alert.setTitle("Erreur de validation");
            alert.setContentText("Le numéro de téléphone doit contenir 8 chiffres.");
            alert.showAndWait();
            return;
        }

        // Vérification du format de l'email
        if (!tf_email.getText().matches("^[\\w.-]+@[\\w.-]+\\.[a-z]{2,}$")) {
            Alert alert = new Alert(Alert.AlertType.ERROR);
            alert.setTitle("Erreur de validation");
            alert.setContentText("L'adresse email est invalide.");
            alert.showAndWait();
            return;
        }

        // Création d'un nouveau sponsor avec les données fournies
        Sponsor sponsor = new Sponsor(
                tf_nom.getText(),
                tf_type.getText(),
                tf_telephone.getText(),
                tf_email.getText()
        );

        // Utilisation du service pour ajouter le sponsor
        ServiceSponsor serviceSponsor = new ServiceSponsor();
        try {
            serviceSponsor.ajouter(sponsor);

            // Afficher une alerte de succès
            Alert alert = new Alert(Alert.AlertType.INFORMATION);
            alert.setTitle("Succès");
            alert.setContentText("Sponsor ajouté avec succès !");
            alert.showAndWait();

            // Réinitialiser les champs après ajout
            resetFields();

        } catch (SQLException e) {
            // Afficher une alerte d'erreur en cas de problème avec la base de données
            Alert alert = new Alert(Alert.AlertType.ERROR);
            alert.setTitle("Erreur");
            alert.setContentText("Une erreur s'est produite lors de l'ajout du sponsor : " + e.getMessage());
            alert.showAndWait();
            System.out.println(e.getMessage());
        }
    }

    // Méthode pour réinitialiser les champs de texte
    private void resetFields() {
        tf_nom.clear();
        tf_type.clear();
        tf_telephone.clear();
        tf_email.clear();
    }

    // Gestionnaire d'événements pour le bouton "Back"
    @FXML
    private void handleBackButton(ActionEvent event) {
        try {
            // Charger le fichier FXML de l'interface d'affichage des sponsors
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/affichersponsor.fxml"));
            Parent root = loader.load();

            // Créer une nouvelle scène avec l'interface d'affichage des sponsors
            Scene scene = new Scene(root);

            // Obtenir la scène actuelle et la remplacer par la nouvelle scène
            Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow();
            stage.setScene(scene);
            stage.show();
        } catch (IOException e) {
            System.err.println("Erreur lors du chargement de l'interface d'affichage des sponsors : " + e.getMessage());
        }
    }
}