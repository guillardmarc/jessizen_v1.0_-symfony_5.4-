<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use App\Entity\Categories;
use App\Entity\Users;
use App\Entity\UsersLinks;
use App\Entity\Websites;
use App\Entity\WebsitesUpdates;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\Date;

class AppFixtures extends Fixture
{
    private $encoder;
    protected $slugger;

    public function __construct(UserPasswordEncoderInterface $encoder, SluggerInterface $slugger)
    {
       $this->encoder = $encoder;
       $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        // Admin user initialisation
        $admin = new Users();
        // Admin user creation
        $admin->setCreatedAt(new DateTime())
              ->setModifiedAt(new DateTime())
              ->setEmail('guillardmarc44@gmail.com')
              ->setRoles(['ROLE_USER','ROLE_AUTHOR','ROLE_ADMIN'])
              ->setPseudo('marco')
              ->setPictureProfilAlt('panda_roux.png')
              ->setPictureProfilLink('uploads/users/admin_13-04-2022/panda_roux.png')
              ->setPictureProfilName('panda_roux.png')
              ->setIsVerified(1)
              ->setWebsiteSettlementAccept(1);
        $password = $this->encoder->encodePassword($admin, 'guillardmarc44@gmail.com');
        $admin->setPassword($password);
        // Admin user persist
        $manager->persist($admin);

        // Admin user link initialisation
        $adminUserLink = new UsersLinks();
        // Admin user link creation
        $adminUserLink->setCreatedAt(new DateTime())
                      ->setType('website')
                      ->setUrl('https://marcguillard.fr')
                      ->setUser($admin);
        // Admin user link persist
        $manager->persist($adminUserLink);

        // Website loop
        for ($i=0; $i<2; $i++) {
            $websiteNumber = $i+1;
            // Website initialisation
            $website = new Websites();
            // Website creation
            $website->setCreatedAt(new DateTime())
                    ->setModifiedAt(new DateTime())
                    ->setLogoText('Jessizen')
                    ->setLogoPictureAlt('JessiZen_logo.png')
                    ->setLogoPictureLink('uploads/websites/website_13-04-2022/logo/JessiZen_logo.png')
                    ->setLogoPictureName('JessiZen_logo.png')
                    ->setCopyright('Lorem ipsum dolor sit amet.')
                    ->setRegulation('
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec consectetur nisi dolor. Phasellus efficitur id mi sit amet convallis. Proin accumsan nulla quis aliquet accumsan. Ut eu tempor purus. Etiam euismod ex sed mauris tristique, eget auctor urna lobortis. Aenean eleifend eros a elit vehicula, sit amet faucibus odio accumsan. Nulla tristique odio aliquet, accumsan purus in, cursus augue. Phasellus non erat ut risus rhoncus ullamcorper. Vestibulum in eleifend magna. Praesent lacinia, arcu nec congue elementum, velit tortor ultrices dui, malesuada lacinia enim ipsum id nibh. Aliquam fermentum quis ligula vitae auctor. Proin eu ante maximus, vehicula justo vel, tincidunt lectus.
                    </p>
                    <p>
                        Praesent aliquet, tortor ac lobortis feugiat, est odio laoreet nibh, in tincidunt enim ipsum vel sem. Aenean eu nibh eget eros tempor consequat vitae vel sem. Maecenas in turpis ut ligula varius ornare at at mi. Nullam vel nulla eros. Sed sagittis est vitae enim vestibulum posuere in eu enim. Mauris auctor vulputate augue, at blandit sem porttitor in. Proin sit amet mattis lectus. Proin posuere vulputate justo vel sollicitudin. Nulla facilisi. Integer sit amet orci ut massa feugiat posuere a sit amet nisi. Phasellus sagittis posuere tellus, sed lacinia libero hendrerit eu. Maecenas tincidunt, lectus blandit porttitor ultricies, mauris elit convallis tellus, ut consectetur metus odio nec dui. Integer rhoncus enim nec nulla consectetur, vel commodo mauris dictum. Vivamus sit amet mollis turpis, ut consequat mi. Vestibulum molestie lorem justo, in euismod mauris sagittis vel.
                    </p>
                    <p>
                        Nullam vel mollis ante. Etiam pharetra pharetra faucibus. Cras in sapien pulvinar, pulvinar dolor sit amet, rhoncus ipsum. Sed ac congue tortor. Suspendisse luctus mi ac nulla aliquet, vitae scelerisque nisi rhoncus. Sed sit amet viverra ex, sit amet mattis ipsum. Nulla ultrices at nisl id sagittis. Nam vitae iaculis dolor. Duis quis ullamcorper velit. Etiam tincidunt porta ligula, eu convallis massa tempus quis. Morbi gravida suscipit risus, vel fringilla est congue sit amet. Sed lobortis sollicitudin lobortis.
                    </p>
                    <p>
                        Nam quam quam, eleifend vel volutpat vitae, tristique congue tortor. Maecenas quis nunc placerat, dignissim mi vel, tempor leo. Vivamus aliquet sem eros, id sagittis ante aliquam accumsan. Sed vel nibh non elit egestas semper. Mauris nisl tortor, maximus eu nunc quis, rhoncus imperdiet est. Mauris rutrum placerat venenatis. Aenean tempor, est eu fermentum vehicula, ex lacus volutpat arcu, nec maximus turpis mi ultrices nunc. Fusce ullamcorper ut mi sed consectetur. Etiam sit amet erat vel ex cursus ullamcorper id vel sapien. Curabitur ultrices tristique elementum. Donec tempus suscipit finibus. Vivamus malesuada, metus at condimentum faucibus, odio ipsum pulvinar arcu, facilisis vulputate purus risus in neque.
                    </p>
                    <p>
                        Pellentesque tincidunt eros at sem rutrum tempus. Aenean rutrum eros feugiat volutpat rutrum. Nullam id tellus rutrum, vulputate justo imperdiet, ullamcorper eros. Suspendisse sollicitudin dui sit amet ipsum fermentum feugiat. Duis lobortis massa malesuada, congue nibh vel, sagittis ante. Nulla semper auctor efficitur. Duis auctor ornare augue non ultrices. Etiam ut nulla justo.
                    </p>
                    ')
                    ->setPresentationText('
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec consectetur nisi dolor. Phasellus efficitur id mi sit amet convallis. Proin accumsan nulla quis aliquet accumsan. Ut eu tempor purus. Etiam euismod ex sed mauris tristique, eget auctor urna lobortis. Aenean eleifend eros a elit vehicula, sit amet faucibus odio accumsan. Nulla tristique odio aliquet, accumsan purus in, cursus augue. Phasellus non erat ut risus rhoncus ullamcorper. Vestibulum in eleifend magna. Praesent lacinia, arcu nec congue elementum, velit tortor ultrices dui, malesuada lacinia enim ipsum id nibh. Aliquam fermentum quis ligula vitae auctor. Proin eu ante maximus, vehicula justo vel, tincidunt lectus.
                    </p>
                    ')
                    ->setPresentationPictureAlt('https://loremflickr.com/320/240?random=1'.$websiteNumber)
                    ->setPresentationPictureLink('https://loremflickr.com/320/240?random=1'.$websiteNumber)
                    ->setPresentationPictureName('https://loremflickr.com/320/240?random=1'.$websiteNumber)
                    ->setVersion('1')
                    ->setAuthor($admin)
                    ->setDevelopper($admin)
                    ->setOwner($admin);
            if ($i == 0){
                $website->setPublicationDate(new DateTime());
            }
            // Website persist
            $manager->persist($website);

            // WebsiteUpdate loop
            for ($i=0; $i<2; $i++) {
                $websiteUpdateNumber = $i+1;
                $underVersion = (new DateTime())->format('Ym');
                // WebsiteUpdate initialisation
                $websiteUpdate = new WebsitesUpdates();
                // WebsiteUpdate création
                $websiteUpdate->setCreatedAt(new DateTime())
                              ->setModifiedAt(new DateTime())
                              ->setTitle('Update website n°'.$websiteUpdateNumber)
                              ->setDate(new DateTime())
                              ->setUnderVersion($underVersion.$websiteNumber)
                              ->setAuthor($admin)
                              ->setWebsite($website);
                // WebsiteUpdate manager
                $manager->persist($websiteUpdate);
            }
        }

        // Author loop
        for ($i=0; $i<2; $i++) { 
            $authorNumber = $i+1;
            // Author initialisation
            $author = new Users();
            // Author creation
            $author->setCreatedAt(new DateTime())
                   ->setModifiedAt(new DateTime())
                   ->setEmail('author0'.$authorNumber.'@author.author')
                   ->setRoles(['ROLE_USER','ROLE_AUTHOR'])
                   ->setPseudo('author0'.$authorNumber)
                   ->setIsVerified(1)
                   ->setWebsiteSettlementAccept(1);
            $password = $this->encoder->encodePassword($admin, 'author0'.$authorNumber.'@author.author');
            $author->setPassword($password);
            // Author user persist
            $manager->persist($author);
        }
    
        for ($i=0; $i<4; $i++) { 
            $categoryNumber = $i+1;
            // Category initialisation
            $category = new Categories();
            // Category creation
            $category->setCreatedAt(new DateTime())
                     ->setModifiedAt(new DateTime())
                     ->setTitle('Category'.$categoryNumber)
                     ->setSlug($this->slugger->slug($category->getTitle()))
                     ->setMoreInfo('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum porta.')
                     ->setPictureAlt('https://loremflickr.com/320/240?random=2'.$categoryNumber)
                     ->setPictureLink('https://loremflickr.com/320/240?random=2'.$categoryNumber)
                     ->setPictureName('https://loremflickr.com/320/240?random=2'.$categoryNumber)
                     ->setAuthor($admin);
            // Category persist
            $manager->persist($category);

            // Article loop
            for ($j=0; $j<5; $j++) { 
                $articleNumber = $j+1;
                // Article initialisation
                $article = new Articles();
                // Article creation
                $article->setCreatedAt(new DateTime())
                        ->setModifiedAt(new DateTime())
                        ->setTitle('Article'.$articleNumber.'/category'.$categoryNumber)
                        ->setSlug($this->slugger->slug($article->getTitle()))
                        ->setContent('
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec consectetur nisi dolor. Phasellus efficitur id mi sit amet convallis. Proin accumsan nulla quis aliquet accumsan. Ut eu tempor purus. Etiam euismod ex sed mauris tristique, eget auctor urna lobortis. Aenean eleifend eros a elit vehicula, sit amet faucibus odio accumsan. Nulla tristique odio aliquet, accumsan purus in, cursus augue. Phasellus non erat ut risus rhoncus ullamcorper. Vestibulum in eleifend magna. Praesent lacinia, arcu nec congue elementum, velit tortor ultrices dui, malesuada lacinia enim ipsum id nibh. Aliquam fermentum quis ligula vitae auctor. Proin eu ante maximus, vehicula justo vel, tincidunt lectus.
                        </p>
                        <p>
                            Praesent aliquet, tortor ac lobortis feugiat, est odio laoreet nibh, in tincidunt enim ipsum vel sem. Aenean eu nibh eget eros tempor consequat vitae vel sem. Maecenas in turpis ut ligula varius ornare at at mi. Nullam vel nulla eros. Sed sagittis est vitae enim vestibulum posuere in eu enim. Mauris auctor vulputate augue, at blandit sem porttitor in. Proin sit amet mattis lectus. Proin posuere vulputate justo vel sollicitudin. Nulla facilisi. Integer sit amet orci ut massa feugiat posuere a sit amet nisi. Phasellus sagittis posuere tellus, sed lacinia libero hendrerit eu. Maecenas tincidunt, lectus blandit porttitor ultricies, mauris elit convallis tellus, ut consectetur metus odio nec dui. Integer rhoncus enim nec nulla consectetur, vel commodo mauris dictum. Vivamus sit amet mollis turpis, ut consequat mi. Vestibulum molestie lorem justo, in euismod mauris sagittis vel.
                        </p>
                        <p>
                            Nullam vel mollis ante. Etiam pharetra pharetra faucibus. Cras in sapien pulvinar, pulvinar dolor sit amet, rhoncus ipsum. Sed ac congue tortor. Suspendisse luctus mi ac nulla aliquet, vitae scelerisque nisi rhoncus. Sed sit amet viverra ex, sit amet mattis ipsum. Nulla ultrices at nisl id sagittis. Nam vitae iaculis dolor. Duis quis ullamcorper velit. Etiam tincidunt porta ligula, eu convallis massa tempus quis. Morbi gravida suscipit risus, vel fringilla est congue sit amet. Sed lobortis sollicitudin lobortis.
                        </p>
                        <p>
                            Nam quam quam, eleifend vel volutpat vitae, tristique congue tortor. Maecenas quis nunc placerat, dignissim mi vel, tempor leo. Vivamus aliquet sem eros, id sagittis ante aliquam accumsan. Sed vel nibh non elit egestas semper. Mauris nisl tortor, maximus eu nunc quis, rhoncus imperdiet est. Mauris rutrum placerat venenatis. Aenean tempor, est eu fermentum vehicula, ex lacus volutpat arcu, nec maximus turpis mi ultrices nunc. Fusce ullamcorper ut mi sed consectetur. Etiam sit amet erat vel ex cursus ullamcorper id vel sapien. Curabitur ultrices tristique elementum. Donec tempus suscipit finibus. Vivamus malesuada, metus at condimentum faucibus, odio ipsum pulvinar arcu, facilisis vulputate purus risus in neque.
                        </p>
                        <p>
                            Pellentesque tincidunt eros at sem rutrum tempus. Aenean rutrum eros feugiat volutpat rutrum. Nullam id tellus rutrum, vulputate justo imperdiet, ullamcorper eros. Suspendisse sollicitudin dui sit amet ipsum fermentum feugiat. Duis lobortis massa malesuada, congue nibh vel, sagittis ante. Nulla semper auctor efficitur. Duis auctor ornare augue non ultrices. Etiam ut nulla justo.
                        </p>
                        ')
                        ->setPictureTopAlt('https://loremflickr.com/320/240?random=3'.$articleNumber)
                        ->setPictureTopLink('https://loremflickr.com/320/240?random=3'.$articleNumber)
                        ->setPictureTopName('https://loremflickr.com/320/240?random=3'.$articleNumber)
                        ->setAuthor($author)
                        ->addCategory($category);
                if ($j%2 == 0){
                    $note = rand(1,5);
                    $viewNumber = rand(1,20);
                    $article->setNote($note)
                            ->setPublicationDate(new DateTime())
                            ->setVoterNumber($note)
                            ->setViewNumber($viewNumber);
                }
                // Article persist
                $manager->persist($article);
            }
        }

        $manager->flush();
    }
}
