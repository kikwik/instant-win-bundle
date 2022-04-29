KikwikInstantWinBundle
======================

Instant Win manager for symfony 5


Installation
------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require kikwik/instant-win-bundle
```

Configuration
-------------

Make your Configuration entity and repository extends proper interfaces (and use traits)

```php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ConfigurationRepository;
use Kikwik\InstantWinBundle\Interfaces\ConfigurationInterface;
use Kikwik\InstantWinBundle\Traits\ConfigurationTrait;

/**
 * @ORM\Entity(repositoryClass=ConfigurationRepository::class)
 */
class Configuration implements ConfigurationInterface
{
    use ConfigurationTrait;

    //...
}
```

```php
namespace App\Repository;

use App\Entity\Configuration;
use Kikwik\InstantWinBundle\Interfaces\ConfigurationRepositoryInterface;
use Kikwik\InstantWinBundle\Traits\ConfigurationRepositoryTrait;

class ConfigurationRepository extends ServiceEntityRepository implements ConfigurationRepositoryInterface
{
    use ConfigurationRepositoryTrait;

    //...
}
```

Make your Lead entity and repository extends proper interfaces (and use traits)

```php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ConfigurationRepository;
use Kikwik\InstantWinBundle\Interfaces\ConfigurationInterface;
use Kikwik\InstantWinBundle\Traits\ConfigurationTrait;

/**
 * @ORM\Entity(repositoryClass=ConfigurationRepository::class)
 */
class Configuration implements ConfigurationInterface
{
    use ConfigurationTrait;

    //...
}
```

```php
namespace App\Repository;

use App\Entity\Configuration;
use Kikwik\InstantWinBundle\Interfaces\LeadRepositoryInterface;
use Kikwik\InstantWinBundle\Traits\LeadRepositoryTrait;

class LeadRepository extends ServiceEntityRepository implements LeadRepositoryInterface
{
    use LeadRepositoryTrait;

    //...
}
```

Make migrations and update your database

```console
$ php bin/console make:migration
$ php bin/console doctrine:migrations:migrate
```

Usage
-----

Check lottery in your controller

```php
namespace App\Controller;

class CompetitionController extends AbstractController
{
 /**
     * @Route("/scopri-se-hai-vinto", name="app_competition_instantWin")
     */
    public function step3instantWin(Request $request, InstantWin $instantWin)
    {
        // call instant win lottery
        $lead->setIsInstantWinner($instantWin->lottery());
        $message = $lead->getIsInstantWinner()
            ? $this->configuration->getInstantWinWinnerMessage()
            : $this->configuration->getInstantWinLooserMessage();

        // send $message as sms
        $smsLog = $smsGateway->send($this->configuration->getInstantWinSenderName(),$lead->getPhoneNumber(), $message);
        
        if(in_array($smsLog->getResponseGroup(), ['REJECTED','UNDELIVERABLE']))
        {
            // reset instant win in case of recipient error
            $lead->setIsInstantWinner(false);
        }
        $this->em->persist($lead);
        $this->em->flush();
        
    }
}
```