#ifndef MAINWINDOW_H
#define MAINWINDOW_H

#include <QMainWindow>
#include"partenaire.h"

QT_BEGIN_NAMESPACE
namespace Ui {
class MainWindow;
}
QT_END_NAMESPACE

class MainWindow : public QMainWindow
{
    Q_OBJECT

public:
    MainWindow(QWidget *parent = nullptr);
    ~MainWindow();

private slots:
    void on_pushButton_clicked();

    void on_pushButton_2_clicked();

    void on_pushButton_3_clicked();



    void on_pushButton_4_clicked();

    void on_lineEdit_textChanged(const QString &arg1);
     void rechercher(const QString &texte);

    void on_pushButton_5_clicked();

     void on_pushButton_6_clicked();

    void on_pushButton_7_clicked();

     void on_pushButton_8_clicked();

    void on_recherche_LE_textEdited(const QString &arg1);

     void on_recherche_LE_textChanged(const QString &arg1);

 private:
    Ui::MainWindow *ui;
    partenaire p;


    bool modifiercontrat(const QString& dureeContrat, const QString& nouveaudureeContrat);

};
#endif // MAINWINDOW_H
