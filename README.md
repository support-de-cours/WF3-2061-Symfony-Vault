# User Entity

- password                  Types::STRING -> 255
- email                     Types::STRING -> 255
- roles                     Types::JSON

- firstname                 Types::STRING -> 40
- lastname                  Types::STRING -> 40
- fullname                  Types::STRING -> 81
- screenname                Types::STRING -> 43
- birthday                  Types::DATE_IMMUTABLE
- gender                    Types::STRING -> columnDefinition: enum('M','F','N')
- country                   Types::STRING -> 2 -> fixed
- connectionsCounter        Types::INTEGER

- registerAt                Types::DATETIME_IMMUTABLE
- lastLoginAt               Types::DATETIME_MUTABLE


# Registration Form

- email                     RepeatedType -> EmailType
- confirmation email
- password                  RepeatedType -> PasswordType
- confirmation password
- firstname                 TextType
- lastname                  TextType
- birthday                  BirthdayType
- gender                    ChoiceType
- country                   CountryType
- agreeTerms                CheckboxType


# Login Form

- email
- password


# Pages User / Security

- login
- logout
- register
- Account / Profile
    Affiche les données du compte
    + Modification du mot de passe
- forgotten password


# Admin