#include "chat.h"
#include "partenaire.h"
#include "ui_chat.h"

chat::chat(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::chat)
{
    ui->setupUi(this);
    QPixmap image("C:/Users/MSI/Pictures/8058698-removebg-preview.png");
    ui->labelImage->setPixmap(image.scaled(150, 150));

}

chat::~chat()
{
    delete ui;
}

/*QString chat::generateResponse(QString userInput)
{
    userInput = userInput.toLower();//c
    QSqlQuery query;
    QString response;


    if (userInput.contains("bonjour") || userInput.contains("salut"))
    {
        return "Bonjour ! Comment puis-je vous aider ?";
    }
    else if (userInput.contains("donner moi des informations sur l entreprise dabchy"))
    {
        return "Dabchy est une entreprise tunisienne fondée en 2015. Elle opère dans le domaine de la vente en ligne, "
               "offrant une plateforme pour acheter et vendre des produits neufs et d'occasion. La plateforme couvre diverses catégories telles que la mode, "
               "l'électronique, les accessoires et bien plus encore. ";
    }

    else if (userInput.contains("donner moi des informations sur l entreprise oredoo"))
    {
        return "oredoo est une entreprise tunisienne fondée en 2015. Elle opère dans le domaine de la vente en ligne, "
               "offrant une plateforme pour acheter et vendre des produits neufs et d'occasion. La plateforme couvre diverses catégories telles que la mode, "
               "l'électronique, les accessoires et bien plus encore. ";
    }

    else if (userInput.contains("donner moi des informations sur nexapp"))
    {
        return "NexApp Insurance est une société innovante qui se distingue par son approche moderne de l'assurance. Forte de son expertise dans le domaine des technologies de l'information, NexApp Insurance s'efforce de repousser les limites de l'industrie de l'assurance en proposant des solutions numériques novatrices. . ";
    }

    else if (userInput.contains("esprit"))
    {
        return "Matricule fiscale : 124pp\n"
               "Adresse : lac 2\n"
               "Numéro de téléphone : 98271000\n"
               "Secteur d'activité : Education\n"
               "Intérêt : ppp\n"
               "Début du contrat : 21/05/2022\n"
               "Fin du contrat : 22/05/2023";
    }
    else if (userInput.contains("dabchy"))
    {
        return "Matricule fiscale : 105p\n"
               "Adresse : rue des jasmins\n"
               "Numéro de téléphone : 29899854\n"
               "Secteur d'activité : commerce\n"
               "Intérêt : ppp\n"
               "Début du contrat : 21/04/2022\n"
               "Fin du contrat : 22/02/2023";
    }
    else if (userInput.contains("projet"))
    {
        return "Ça sonne intéressant ! Parlez-moi-en plus.";
    }
    else if (userInput.contains("chat"))
    {
        return "Ah, vous parlez de moi ! Que puis-je faire pour vous aujourd'hui ?";
    }

    else if (userInput.contains("matricule")) {
        // Extraire la matricule fiscale de la requête utilisateur
        QString matriculeFiscale = userInput.split("matricule").last().trimmed();


        query.prepare("SELECT NOM_ENTREPRISE FROM FOOL WHERE MATRICULE_FISCALE = :matricule");
        query.bindValue(":matricule", matriculeFiscale);
        if (query.exec() && query.next()) {
            QString entreprise = query.value(0).toString();
            response = "Le nom de l'entreprise associée à la matricule fiscale " + matriculeFiscale + " est : " + entreprise;
        } else {
            response = "Aucune entreprise trouvée pour la matricule fiscale fournie.";
        }
    }





    else
    {
        return "Je suis désolé, je ne comprends pas. Pourriez-vous reformuler ?";

    }
    //executer une requete sql








}*/


QString chat::generateResponse(QString userInput)
{
    userInput = userInput.toLower();
    QSqlQuery query;
    QString response;

    if (userInput.contains("bonjour") || userInput.contains("salut"))
    {
        return "Bonjour ! Comment puis-je vous aider ?";
    }
    else if (userInput.contains("donner moi des informations sur l entreprise dabchy"))
    {
        return "Dabchy est une entreprise tunisienne fondée en 2015. Elle opère dans le domaine de la vente en ligne, "
               "offrant une plateforme pour acheter et vendre des produits neufs et d'occasion. La plateforme couvre diverses catégories telles que la mode, "
               "l'électronique, les accessoires et bien plus encore. ";
    }
    // Ajoutez d'autres cas selon vos besoins...

    else if (userInput.contains("matricule") && userInput.trimmed() == "matricule") {
        return "Veuillez spécifier une matricule fiscale après le mot 'matricule'.";
    }
    else if (userInput.contains("matricule")) {
        // Extraire la matricule fiscale de la requête utilisateur
        QString matriculeFiscale = userInput.split("matricule").last().trimmed();

        query.prepare("SELECT NOM_ENTREPRISE FROM FOOL WHERE MATRICULE_FISCALE = :matricule");
        query.bindValue(":matricule", matriculeFiscale);
        if (query.exec() && query.next()) {
            QString entreprise = query.value(0).toString();
            response = "Le nom de l'entreprise associée à la matricule fiscale " + matriculeFiscale + " est : " + entreprise;
        } else {
            response = "Aucune entreprise trouvée pour la matricule fiscale fournie.";
        }
    }
    // Ajoutez d'autres cas selon vos besoins...

    else
    {
        return "Je suis désolé, je ne comprends pas. Pourriez-vous reformuler ?";
    }

    return response;
}

void chat::afficherHistoriqueQuestions()
{
    QString historique;

    // Parcours de la liste des questions et construction de la chaîne d'historique
    for (const QString &question : userQuestions)
    {
        historique += question + "\n";
    }

    // Affichage de l'historique des questions dans un QLabel ou autre zone de texte de votre choix
     QFont font("Segoe Print", 10);
    ui->labelHistorique->setFont(font);
    ui->labelHistorique->setText(historique);
}



void chat::on_pushButton_clicked()

{
    QString message = ui->textEditMessage->toPlainText();

    // Ajouter la question de l'utilisateur à l'historique
    userQuestions.append(message);

    // Affichage du message de l'utilisateur dans le QLabel dédié
    ui->labelUserMessage->setText("Utilisateur:\n" + message);

    // Génération d'une réponse en fonction de l'entrée utilisateur
    QString currentResponse = generateResponse(message);

    // Affichage de la réponse du chat dans un QLabel distinct
    ui->labelChatResponse->setText("Bot:\n" + currentResponse);
    QFont font("Segoe Print", 10); // Remplacez 10 par la taille de police souhaitée
    ui->labelChatResponse->setFont(font);

    // Effacement du texte saisi dans le QTextEdit
    ui->textEditMessage->clear();
    afficherHistoriqueQuestions();

}



void chat::on_pushButton_3_clicked()
{
    this->close();

}


































/* userInput = userInput.toLower();//c


    if (userInput.contains("bonjour") || userInput.contains("salut"))
    {
        return "Bonjour ! Comment puis-je vous aider ?";
    }
    else if (userInput.contains("donner moi des informations sur l entreprise dabchy"))
    {
        return "Dabchy est une entreprise tunisienne fondée en 2015. Elle opère dans le domaine de la vente en ligne, "
               "offrant une plateforme pour acheter et vendre des produits neufs et d'occasion. La plateforme couvre diverses catégories telles que la mode, "
               "l'électronique, les accessoires et bien plus encore. ";
    }

    else if (userInput.contains("donner moi des informations sur l entreprise oredoo"))
    {
        return "oredoo est une entreprise tunisienne fondée en 2015. Elle opère dans le domaine de la vente en ligne, "
               "offrant une plateforme pour acheter et vendre des produits neufs et d'occasion. La plateforme couvre diverses catégories telles que la mode, "
               "l'électronique, les accessoires et bien plus encore. ";
    }

    else if (userInput.contains("donner moi des informations sur nexapp"))
    {
        return "NexApp Insurance est une société innovante qui se distingue par son approche moderne de l'assurance. Forte de son expertise dans le domaine des technologies de l'information, NexApp Insurance s'efforce de repousser les limites de l'industrie de l'assurance en proposant des solutions numériques novatrices. . ";
    }

else if (userInput.contains("esprit"))
    {
        return "Matricule fiscale : 124pp\n"
               "Adresse : lac 2\n"
               "Numéro de téléphone : 98271000\n"
               "Secteur d'activité : Education\n"
               "Intérêt : ppp\n"
               "Début du contrat : 21/05/2022\n"
               "Fin du contrat : 22/05/2023";
    }
    else if (userInput.contains("dabchy"))
    {
        return "Matricule fiscale : 105p\n"
               "Adresse : rue des jasmins\n"
               "Numéro de téléphone : 29899854\n"
               "Secteur d'activité : commerce\n"
               "Intérêt : ppp\n"
               "Début du contrat : 21/04/2022\n"
               "Fin du contrat : 22/02/2023";
    }
    else if (userInput.contains("projet"))
    {
        return "Ça sonne intéressant ! Parlez-moi-en plus.";
    }
    else if (userInput.contains("chat"))
    {
        return "Ah, vous parlez de moi ! Que puis-je faire pour vous aujourd'hui ?";
    }
    else
    {
        return "Je suis désolé, je ne comprends pas. Pourriez-vous reformuler ?";

    }*/

