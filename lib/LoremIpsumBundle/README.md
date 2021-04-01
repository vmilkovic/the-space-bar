# Hello LoremIpsumBundle!

NOTICE: This configuration only works if the bundle has a repository.
Current bundle is activated as a library and can't be installed with composer
without further modifications. Also travis CI won't work without repository.

LoremIpsumBundle is a way for you to generate "fake text" into
your Symfony application, but with *just* a little bit more joy
than your normal lorem ipsum.

Install the package with:

```console
composer require knpuniversity/lorem-ipsum-bundle --dev
```

And... that's it! If you're *not* using Symfony Flex, you'll also
need to enable the `KnpU\LoremIpsumBundle\KnpULoremIpsumBundle`
in your `AppKernel.php` file.

## Usage

This bundle provides a single service for generating fake text, which
you can autowire by using the `KnpUIpsum` type-hint:

```php
// src/Controller/SomeController.php

use KnpU\LoremIpsumBundle\KnpUIpsum;
// ...

class SomeController
{
    public function index(KnpUIpsum $knpUIpsum)
    {
        $fakeText = $knpUIpsum->getParagraphs();

        // ...
    }
}
```

You can also access this service directly using the id
`knpu_lorem_ipsum.knpu_ipsum`.

## Configuration

A few parts of the generated text can be configured directly by
creating a new `config/packages/knpu_lorem_ipsum.yaml` file. The
default values are:

```yaml
# config/packages/knpu_lorem_ipsum.yaml
knpu_lorem_ipsum:

    # Whether or not you believe in unicorns
    unicorns_are_real:    true

    # How much do you like sunshine?
    min_sunshine:         3
```

## Extending the Word List

If you're feeling *especially* creative and excited, you can add 
your *own* words to the word generator!

To do that, create a class that implements `WordProviderInterface`:

```php
namespace App\Service;

use KnpU\LoremIpsumBundle\WordProviderInterface;

class CustomWordProvider implements WordProviderInterface
{
    public function getWordList(): array
    {
        return ['beach'];
    }
}
```

And... that's it! If you're using the standard service configuration,
your new class will automatically be registered as a service and used
by the system. If you are not, you will need to register this class
as a service and tag it with `knpu_ipsum_word_provider`.
