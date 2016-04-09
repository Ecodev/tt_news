News
====

The well-known "tt_news" extension but stripped to its bare minimum - the database structure and its TCA configuration. The FE plugin has been removed as delegated to other tool such as [Vidi Frontend](https://github.com/fabarea/vidi_frontend).

To install the extension via Composer, consider the following lines in your root ``composer.json``

```

    {
        "repositories": [
            {
                "type": "git",
                "url": "https://github.com/Ecodev/tt_news.git"
            }
        ],
        "require": {
            "typo3/cms": "7.6.*",
    
            "ecodev/tt-news": "dev-master"
        }
    }

```