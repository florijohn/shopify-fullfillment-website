const inquirer = require('inquirer');
const yaml = require("js-yaml");
const fs = require("fs");

const availableLanguages = [ "de", "en" ];

inquirer
    .prompt([
        {
            type: 'input',
            name: 'dirname',
            message: "Ordnername:",
            validate: v => (!!v && v.indexOf(' ') < 0) || "Bitte gib einen gültigen Ordnernamen ein",
        },
        {
            type: 'checkbox',
            name: 'locale',
            message: "Verfügbare Sprachen:",
            choices: availableLanguages,
            default: availableLanguages,
        }
    ])
    .then(answers => {
        const questions = [];
        answers.locale.forEach(locale => {
            questions.push({
                type: "input",
                name: `${locale}.slug`,
                message: `Slug (${locale}):`,
                validate: v => !!v || "Bitte gib eine Slug für diese Page ein",
            });

            questions.push({
                type: 'input',
                name: `${locale}.title`,
                message: `Seitentitel (${locale}):`,
                validate: v => !!v || "Bitte gib einen Seitentitel ein",
            });

            questions.push({
                type: 'input',
                name: `${locale}.navTitle`,
                message: `Titel in Navi (${locale}):`,
                validate: v => !!v || "Bitte gib einen Titel für die Navigation ein",
            });
        });

        inquirer
            .prompt(questions)
            .then(slugAnswers => {
                const currentTimestamp = new Date().getTime();

                const pageData = {
                    ...answers,
                    locales: slugAnswers,
                    createDate: currentTimestamp,
                    publishDate: currentTimestamp,
                };

                Object.keys(pageData.locales).forEach(locale => {
                    const localizedPage = {
                        slug: pageData.locales[locale].slug,
                        title: pageData.locales[locale].title,
                        nav_title: pageData.locales[locale].navTitle,

                        create_date: pageData.createDate,
                        publish_date: pageData.publishDate,

                        preview_image: "http://placeimg.com/640/480/tech",
                        keywords: ["keyword1", "keyword2"],

                        seo: {
                            title: pageData.locales[locale].title,
                            description: "",
                        },
                        twitter: {
                            title: pageData.locales[locale].title,
                            description: "",
                        },
                        og: {
                            title: pageData.locales[locale].title,
                            description: "",
                        },
                    };

                    const pageYaml = yaml.dump(localizedPage);
                    const fileContent = "---\r\n" + pageYaml + "\r\n---\r\n\r\nContent";
                    const dir = `./pages/${pageData.dirname}`;

                    if (!fs.existsSync(dir)) fs.mkdirSync(dir, { recursive: true });
                    if (!fs.existsSync(`${dir}/images`)) fs.mkdirSync(`${dir}/images`, { recursive: true });
                    if (!fs.existsSync(`${dir}/snippets`)) fs.mkdirSync(`${dir}/snippets`, { recursive: true });

                    fs.writeFileSync(`${dir}/${locale}.md`, fileContent, error => {
                        if (error) return console.error(error);
                        console.log("Seite erstellt.")
                    });
                });
            });
    })
    .catch(error => {
        console.log("does not compute. ooopsy-daisy!");
        console.error(error);
        process.exit(1);
    });
