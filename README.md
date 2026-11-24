<<<<<<< HEAD
# Projeto Áustria — Desktop + Mobile

Este projeto reúne as duas versões na mesma pasta:

- `desktop/`: site PHP/Tailwind/JavaScript e painel administrativo.
- `mobile/`: aplicativo React Native com Expo.

## Desktop (XAMPP)

1. Coloque a pasta `site-austria-integrado` dentro de `C:\xampp\htdocs\`.
2. Inicie Apache e MySQL no XAMPP.
3. Confira a conexão e o banco `austria_site` em `desktop/includes/conexao.php`.
4. Abra `http://localhost/site-austria-integrado/desktop/`.

O projeto desktop mantém seus arquivos PHP, includes, painel e recursos.

## Mobile (Expo)

1. Abra a pasta `mobile` no VS Code.
2. Execute `npm install`.
3. Execute `npx expo start`.
4. Abra no Expo Go pelo QR Code.

## Sobre o banco compartilhado

O desktop continua usando a conexão PHP/MySQL existente. O app mobile está estruturado separadamente em React Native e já apresenta as seções principais. Para os dois consumirem exatamente os mesmos textos e imagens do banco, o próximo passo técnico é disponibilizar endpoints PHP em uma API e configurar o app para consultá-los. O mobile ainda usa conteúdo local nesta versão.
=======
# projeto-austria
>>>>>>> 8002976f4960414d7d0eb74f569e3130772ef95d
