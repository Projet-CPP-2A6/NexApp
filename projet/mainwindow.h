#ifndef MAINWINDOW_H
#define MAINWINDOW_H

#include "employe.h"
#include "connection.h"
#include <QMainWindow>






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
    void on_ajouter_clicked();
    void on_tabWidget_currentChanged(int index);
    void on_tableView_clicked(const QModelIndex &index);
    void on_supprimer_clicked();
    void handleItemClicked(const QModelIndex &index);
    void on_modifier_clicked();
    void on_modifiernour_clicked();
    void recherchecin(const QString &searchText);
private:
    int selectedCIN;
    Ui::MainWindow *ui;
    Employe* e;
    QModelIndex selectedIndex;
};

#endif // MAINWINDOW_H
