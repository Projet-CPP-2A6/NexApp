QT       += core gui sql  printsupport
QT += charts
QT += widgets
greaterThan(QT_MAJOR_VERSION, 4): QT += widgets

CONFIG += c++17

# You can make your code fail to compile if it uses deprecated APIs.
# In order to do so, uncomment the following line.
#DEFINES += QT_DISABLE_DEPRECATED_BEFORE=0x060000    # disables all the APIs deprecated before Qt 6.0.0

SOURCES += \
    add.cpp \
    ajouch.cpp \
    aminee.cpp \
    chat.cpp \
    chrif.cpp \
    client.cpp \
    connexion.cpp \
    constat.cpp \
    employe.cpp \
    interface.cpp \
    main.cpp \
    mainwindow.cpp \
    modif.cpp \
    modifa.cpp \
    modifch.cpp \
    nour.cpp \
    partenaire.cpp \
    pluss.cpp \
    stata.cpp \
    statch.cpp \
    statistique.cpp \
    suppression.cpp \
    supprich.cpp \
    supprima.cpp

HEADERS += \
    add.h \
    ajouch.h \
    aminee.h \
    chat.h \
    chrif.h \
    client.h \
    connexion.h \
    constat.h \
    employe.h \
    interface.h \
    mainwindow.h \
    modif.h \
    modifa.h \
    modifch.h \
    nour.h \
    partenaire.h \
    pluss.h \
    stata.h \
    statch.h \
    statistique.h \
    suppression.h \
    supprich.h \
    supprima.h

FORMS += \
    add.ui \
    ajouch.ui \
    aminee.ui \
    chat.ui \
    chrif.ui \
    connexion.ui \
    interface.ui \
    mainwindow.ui \
    modif.ui \
    modifa.ui \
    modifch.ui \
    nour.ui \
    pluss.ui \
    stata.ui \
    statch.ui \
    statistique.ui \
    suppression.ui \
    supprich.ui \
    supprima.ui

# Default rules for deployment.
qnx: target.path = /tmp/$${TARGET}/bin
else: unix:!android: target.path = /opt/$${TARGET}/bin
!isEmpty(target.path): INSTALLS += target

RESOURCES += \
    ressource.qrc
