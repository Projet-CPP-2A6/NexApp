package tests;

import services.ServiceEvenement;
import services.ServiceSponsor;
import entities.Sponsor;
import utils.mydatabase;
import java.sql.Connection;
import java.sql.SQLException;



import java.util.ArrayList;
import java.util.List;


    public class Main {
        public static void main(String[] args) {
            mydatabase dbInstance = mydatabase.getInstance();
            Connection conn = dbInstance.getConnection();



            try {
                if (conn != null && !conn.isClosed()) {
                    System.out.println("La connexion à la base de données est active.");
                } else {
                    System.out.println("La connexion à la base de données a échoué.");
                }
            } catch (SQLException e) {
                System.out.println("Erreur lors de la vérification de la connexion : " + e.getMessage());
            }


          ServiceSponsor service = new ServiceSponsor();


            try {

                Sponsor sponsor1 = new Sponsor(1, "TechggCorp", "Technologie", "123456789", "contact@techcorp.com");
                Sponsor sponsor2 = new Sponsor(2, "Tech Corp", "Technoloo", "12345lll", "contact@techcorp.com");
            service.ajouter(sponsor1);
            // Message de confirmation
           /* System.out.println("✅ Test réussi : Sponsor ajouté !");
        } catch (SQLException e) {
            System.out.println(" Erreur lors de l'ajout du sponsor !");
            e.printStackTrace(); // Affiche les erreurs SQL si problème}*/



            /*service.modifier(sponsor1);

            System.out.println(" Test réussi : Sponsor modifié avec succès !");*/


            /*int sponsorIdToDelete = 1;


            service.supprimer(sponsorIdToDelete);*/


                // methode pour afficher tous les sponsors

                System.out.println("\n📌 Liste des sponsors enregistrés :");
                List<Sponsor> sponsors = service.afficher();

                if (sponsors.isEmpty()) {
                    System.out.println("⚠️ Aucun sponsor trouvé dans la base de données.");
                } else {
                    for (Sponsor sponsor : sponsors) {
                        System.out.println("🆔 ID: " + sponsor.getId_sp() +
                                " | 🏢 Nom: " + sponsor.getNom() +
                                " | 📌 Type: " + sponsor.getType() +
                                " | 📞 Téléphone: " + sponsor.getTelephone() +
                                " | 📧 Email: " + sponsor.getEmail());
                    }
                }

            } catch (SQLException e) {
                System.out.println("❌ Erreur lors de l'opération !");
                e.printStackTrace();
            }
        }





    }










