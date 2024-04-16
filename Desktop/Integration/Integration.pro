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
    chat.cpp \
    connexion.cpp \
    employe.cpp \
    interface.cpp \
    main.cpp \
    mainwindow.cpp \
    modif.cpp \
    nour.cpp \
    partenaire.cpp \
    statistique.cpp \
    suppression.cpp

HEADERS += \
    add.h \
    chat.h \
    connexion.h \
    employe.h \
    interface.h \
    mainwindow.h \
    modif.h \
    nour.h \
    partenaire.h \
    statistique.h \
    suppression.h

FORMS += \
    add.ui \
    chat.ui \
    connexion.ui \
    interface.ui \
    mainwindow.ui \
    modif.ui \
    nour.ui \
    statistique.ui \
    suppression.ui

# Default rules for deployment.
qnx: target.path = /tmp/$${TARGET}/bin
else: unix:!android: target.path = /opt/$${TARGET}/bin
!isEmpty(target.path): INSTALLS += target

RESOURCES += \
    ressource.qrc
