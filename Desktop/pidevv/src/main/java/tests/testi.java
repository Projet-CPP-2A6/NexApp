package tests;

import entities.Evenement;
import services.ServiceEvenement;
import utils.mydatabase;
import java.sql.Connection;
import java.sql.Date;
import java.sql.SQLException;
import java.math.BigDecimal;
import java.util.ArrayList;
import java.util.List;

public class testi {
    public static void main(String[] args) {
        mydatabase dbInstance = mydatabase.getInstance();
        Connection conn = dbInstance.getConnection();
        ServiceEvenement service = new ServiceEvenement();

        // test de la connexion
        try {
            if (conn != null && !conn.isClosed()) {
                System.out.println(" La connexion à la base de données est active.");
            } else {
                System.out.println(" La connexion à la base de données a échoué.");
            }
        } catch (SQLException e) {
            System.out.println("Erreur lors de la vérification de la connexion : " + e.getMessage());
        }

        try {

            Evenement newEvent = new Evenement(3,"Conférence ", "Technologie",
                    Date.valueOf("2024-06-15"), Date.valueOf("2024-06-17"),
                    "Tunis", new BigDecimal("5000.00"), "Un grand événement technologique", 1);



            // ajout d un evenement

            service.ajouter(newEvent);
            System.out.println(" Événement ajouté avec succès !");




            // modifier


            /*service.modifier(newEvent);*/



            int eventIdToDelete = 4;
            service.supprimer(eventIdToDelete);
            System.out.println("Événement supprimé avec succès !");






            // affichage

            List<Evenement> evenements = service.afficher();
            System.out.println("📋 Liste des événements :");
            for (Evenement ev : evenements) {
                System.out.println(ev);
            }



        } catch (SQLException e) {
            System.out.println("Erreur lors de l'ajout de l'événement !");
            e.printStackTrace();
        }





















    }
}
