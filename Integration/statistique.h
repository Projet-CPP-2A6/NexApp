#ifndef STATISTIQUE_H
#define STATISTIQUE_H

#include <QDialog>

namespace Ui {
class statistique;
}

class statistique : public QDialog
{
    Q_OBJECT

public:
    explicit statistique(QWidget *parent = nullptr);
    ~statistique();

private slots:
    void on_pushButton_clicked();

private:
    Ui::statistique *ui;
};

#endif // STATISTIQUE_H
