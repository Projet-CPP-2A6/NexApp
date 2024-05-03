#ifndef PLUSS_H
#define PLUSS_H

#include <QDialog>

namespace Ui {
class pluss;
}

class pluss : public QDialog
{
    Q_OBJECT

public:
    explicit pluss(QWidget *parent = nullptr);
    ~pluss();

private slots:
    void on_pushButton_clicked();

private:
    Ui::pluss *ui;
};

#endif // PLUSS_H
