package tests;

import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.stage.Stage;

import java.io.IOException;

public class MainFX extends Application {

    public static void main(String[] args) {
        launch(args);
    }

    @Override
    public void start(Stage primaryStage) {
        try {





            FXMLLoader fxmlLoader = new FXMLLoader(getClass().getResource("/affichersponsor.fxml"));
            Parent root = fxmlLoader.load();


            Scene scene = new Scene(root);
            primaryStage.setScene(scene);
            primaryStage.setTitle("ajouter un  evenement ");
            primaryStage.show();
        } catch (IOException e) {

            System.err.println("Erreur lors du chargement du fichier FXML : " + e.getMessage());
            e.printStackTrace();
        }
    }
}
