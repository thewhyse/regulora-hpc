/* eslint-disable */
const {src, dest, parallel, watch} = require('gulp');
const critical = require('critical');

const config = {
  cssCritical: {
    src: './resources/assets/styles/default-critical.scss',
    watch: './resources/assets/styles/**/*.scss',
    dest: './criticals/styles'
    // dest: './resources/assets/styles/critical'
  },
  user: 'mintz',
  pass: 'gold',
};

exports.critical = async() => {
  const pages = [{
    key: 'front-page',
    src: 'https://dev-mintzandgold.pantheonsite.io/'
  }, {
    key: 'single-attorney',
    src: 'https://dev-mintzandgold.pantheonsite.io/attorneys/gabriel-altman/'
  }, {
    key: 'template-attorney',
    src: 'https://dev-mintzandgold.pantheonsite.io/attorneys/'
  }, {
    key: 'template-practices',
    src: 'https://dev-mintzandgold.pantheonsite.io/our-work/'
  }, {
    key: 'single-practice',
    src: 'https://dev-mintzandgold.pantheonsite.io/practices/accountants-liability-practice/'
  }, {
    key: 'template-news',
    src: 'https://dev-mintzandgold.pantheonsite.io/news-insights/'
  }, {
    key: 'single-news',
    src: 'https://dev-mintzandgold.pantheonsite.io/2021/07/30/making-operating-expense-headlines/'
  }, {
    key: 'template-page-with-header',
    src: 'https://dev-mintzandgold.pantheonsite.io/contact-us/'
  }, {
    key: 'template-page-default',
    src: 'https://dev-mintzandgold.pantheonsite.io/about-us/'
  }];
  async function createCritical(page) {
    const
      dest = `./criticals/styles/${page.key}.css`,
      destSmall = `./criticals/styles/smallscreen/${page.key}.css`,
      mobDest = `./criticals/styles/mobile/${page.key}.css`,
      uc_dest = `./uncriticals/styles/${page.key}.css`,
      uc_destSmall = `./uncriticals/styles/smallscreen/${page.key}.css`,
      uc_mobDest = `./uncriticals/styles/mobile/${page.key}.css`,
      generate = async () => {
        // let promises = [];
        await critical.generate({
          src: page.src,
          target: {
            css: dest,
            uncritical: uc_dest,
          },
          width: 1360,
          height: 1080,
          inline: false,
          user: config.user,
          pass: config.pass,
          penthouse: {
            timeout: 900000,
          },
        });
        await critical.generate({
          src: page.src,
          target: {
            css: destSmall,
            uncritical: uc_destSmall,
          },
          width: 992,
          height: 800,
          inline: false,
          user: config.user,
          pass: config.pass,
          penthouse: {
            timeout: 900000,
          },
        });
        await critical.generate({
          src: page.src,
          target: {
            css: mobDest,
            uncritical: uc_mobDest,
          },
          width: 414,
          height: 736,
          inline: false,
          user: config.user,
          pass: config.pass,
          penthouse: {
            timeout: 900000,
          },
        });
        // await Promise.all(promises);
        // const mobile = fs.readFileSync(mobDest, "utf8"),
        //   stream = fs.createWriteStream(dest, {flags: 'a'});
        // stream.on('error', console.error);
        // stream.write(`\n${stringOpen}\n\t${mobile}\n${stringClose}\n`);
        // stream.end();
        // del(mobDest);
      }
    return generate();
  }
  async function processPages(pages) {
    const pagesPromises = pages.map(createCritical);
    await Promise.all(pagesPromises);
    //del(`./dist/styles/critical/mobile/`);
  }
  return processPages(pages);
};
