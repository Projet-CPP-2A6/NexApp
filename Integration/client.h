#ifndef CLIENT_H
#define CLIENT_H

#include <QString>
#include <QDate>
#include <QSqlQuery>
#include <QMessageBox>
#include <QDebug>
#include <QString>
#include <QSqlQueryModel>
#include <QTableView>
#include <QString>
#include <QSqlQuery>
#include <QSqlQueryModel>
#include <QDoubleValidator>
#include <QDateTime>
#include <QStandardItemModel>

class Client
{
public:
    QString cin;
    QString nom;
    QString prenom;
    QString adresse;
    QString numeroTelephone;
    QString email;

public:
    // Constructeurs
    Client() {}
    Client(QString cin, QString nom, QString prenom, QString adresse, QString numeroTelephone, QString email);

    // Getters
    QString getCin() { return cin; }
    QString getNom() { return nom; }
    QString getPrenom() { return prenom; }
    QString getAdresse() { return adresse; }
    QString getNumeroTelephone() { return numeroTelephone; }
    QString getEmail() { return email; }

    // Setters
    void setCin(QString cin);
    void setNom(QString nom);
    void setPrenom(QString prenom);
    void setAdresse(QString adresse);
    void setNumeroTelephone(QString numeroTelephone);
    void setEmail(QString email);

    // CRUD methods
    bool ajouter();
    bool supprimer(const QString& cin);
    QSqlQueryModel* afficher();
    bool modifier(const QString& cin, const QString& nouveauNumeroTelephone, const QString& nouvelleAdresse, const QString& nouvelEmail);
    QStandardItemModel* rechercheClient(QString str, bool rechercheParCIN);
    QSqlQueryModel* TriPar(QString nom);
};

#endif // CLIENT_H
