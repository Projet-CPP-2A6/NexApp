
#ifndef MAINWINDOW_H
#define MAINWINDOW_H
#include "email.h"
#include "employe.h"
#include "connection.h"
#include <QFileDialog>
#include <QPrinter>
#include <QPainter>
#include <QMainWindow>

#include <QtCharts/QChartView>
#include <QtCharts/QPieSeries>
#include <QtCharts/QPieSlice>
#include <QtCharts/QAbstractSeries>
#include <QtCharts/QPieSlice>
#include <QtCharts>

#include <QtWidgets>
#include <QtNetwork>

#include <QtCore>
#include <QTextStream>



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
    void history(int userID, bool userAdded);
    void chart_render();
    void clear_chart_widget();
    void on_ajouter_clicked();
    void on_tabWidget_currentChanged(int index);
    void on_tableView_clicked(const QModelIndex &index);
    void on_supprimer_clicked();
    void handleItemClicked(const QModelIndex &index);
    void on_modifier_clicked();
    void on_modifiernour_clicked();
    void recherchecin(const QString &searchText);
    void on_pdf_clicked();
    void on_ajout2_clicked();
    void on_tri_clicked();
    void on_refresh_clicked();
    void on_envoyer_email_clicked();
private:
    void sendConfirmationEmail(const QString &recipient, const QString &eventName, const QString &eventDescription, const QString &eventLocation, const QString &eventDate);
    void emailStatus(const QString &status);
    int selectedCIN;
    Ui::MainWindow *ui;
    Employe* e;
    QModelIndex selectedIndex;
};

#endif // MAINWINDOW_H
