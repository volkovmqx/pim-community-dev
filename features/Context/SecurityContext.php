<?php

namespace Context;


use Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Doctrine\Common\Util\ClassUtils;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecurityContext extends RawMinkContext implements KernelAwareInterface
{
    /** @var KernelInterface */
    protected $kernel;

    /** @var Client */
    protected $client;

    /**
     * @param string $baseUrl
     */
    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @When /^I make a direct authenticated DELETE call on the "([^"]*)" user group$/
     */
    public function iMakeADirectCallToDeleteTheUserGroup($userGroupLabel)
    {
        $routeName = 'oro_user_group_delete';

        $userGroup = $this->kernel
            ->getContainer()
            ->get('pim_user.repository.group')
            ->findOneByIdentifier($userGroupLabel);

        $url = $this->kernel
            ->getContainer()
            ->get('router')
            ->generate($routeName, ['id' => $userGroup->getId()]);

        $this->doCall('DELETE', $url);
    }

    /**
     * @When /^I make a direct authenticated DELETE call on the "([^"]*)" user role/
     */
    public function iMakeADirectCallToDeleteTheUserRole($role)
    {
        $routeName = 'oro_user_role_delete';

        $userRole = $this->kernel
            ->getContainer()
            ->get('pim_user.repository.role')
            ->findOneByIdentifier($role);

        $url = $this->kernel
            ->getContainer()
            ->get('router')
            ->generate($routeName, ['id' => $userRole->getId()]);

        $this->doCall('DELETE', $url);
    }

    /**
     * @When /^I make a direct authenticated DELETE call on the "([^"]*)" user/
     */
    public function iMakeADirectCallToDeleteTheUser($username)
    {
        $routeName = 'oro_user_user_delete';

        $user = $this->kernel
            ->getContainer()
            ->get('pim_user.repository.user')
            ->findOneByIdentifier($username);

        $url = $this->kernel
            ->getContainer()
            ->get('router')
            ->generate($routeName, ['id' => $user->getId()]);

        $this->doCall('DELETE', $url);
    }

    /**
     * @When /^I make a direct authenticated DELETE call on the last comment of "([^"]*)" product$/
     */
    public function iMakeADirectAuthenticatedDeleteCallOnTheLastCommentOfProduct($productIdentifier)
    {
        $routeName = 'pim_comment_comment_delete';

        $product = $this->kernel
            ->getContainer()
            ->get('pim_catalog.repository.product')
            ->findOneByIdentifier($productIdentifier);

        $comments = $this->kernel
            ->getContainer()
            ->get('pim_comment.repository.comment')
            ->getComments(
                ClassUtils::getClass($product),
                $product->getId()
            );

        $lastComment = end($comments);

        $url = $this->kernel
            ->getContainer()
            ->get('router')
            ->generate($routeName, ['id' => $lastComment->getId()]);

        $this->doCall('DELETE', $url);
    }

    /**
     * @When /^I make a direct authenticated DELETE call on the first datagrid view$/
     */
    public function iMakeADirectAuthenticatedDeleteCallOnTheFirstDatagridView()
    {
        $routeName = 'pim_datagrid_view_remove';

        $views = $this->kernel
            ->getContainer()
            ->get('pim_datagrid.repository.datagrid_view')
            ->findAll();

        $firstView = current($views);

        $url = $this->kernel
            ->getContainer()
            ->get('router')
            ->generate($routeName, ['id' => $firstView->getId()]);

        $this->doCall('DELETE', $url);
    }

    /**
     * @When /^I make a direct authenticated DELETE call on the first datagrid view as "([^"]*)"$/
     */
    public function iMakeADirectAuthenticatedDeleteCallOnTheFirstDatagridViewAs($username)
    {
        $routeName = 'pim_datagrid_view_remove';

        $views = $this->kernel
            ->getContainer()
            ->get('pim_datagrid.repository.datagrid_view')
            ->findAll();

        $firstView = current($views);

        $url = $this->kernel
            ->getContainer()
            ->get('router')
            ->generate($routeName, ['id' => $firstView->getId()]);

        $this->doCall('DELETE', $url, [], $username);
    }

    /**
     * @When /^I make a direct authenticated GET call to mass delete "([^"]*)" product$/
     */
    public function iMakeADirectAuthenticatedGetCallToMassDeleteProduct($productIndentifier)
    {
        $routeName = 'pim_datagrid_mass_action';

        $product = $this->kernel
            ->getContainer()
            ->get('pim_catalog.repository.product')
            ->findOneByIdentifier($productIndentifier);

        $url = $this->kernel
            ->getContainer()
            ->get('router')
            ->generate($routeName, ['gridName' => 'product-grid', 'actionName' => 'delete']);

        $this->doCall('GET', $url, [
            'inset' => 1,
            'values' => $product->getId()
        ]);
    }

    /**
     * @When /^I make a direct authenticated DELETE call on the "([^"]*)" association type$/
     */
    public function iMakeADirectAuthenticatedDeleteCallOnTheAssociationType($associationTypeCode)
    {
        $routeName = 'pim_enrich_associationtype_remove';

        $associationType = $this->kernel
            ->getContainer()
            ->get('pim_catalog.repository.association_type')
            ->findOneByIdentifier($associationTypeCode);

        $url = $this->kernel
            ->getContainer()
            ->get('router')
            ->generate($routeName, ['id' => $associationType->getId()]);

        $this->doCall('DELETE', $url);
    }

    /**
     * @When /^I make a direct authenticated GET call to create an attribute option for "([^"]*)" attribute$/
     */
    public function iMakeADirectAuthenticatedGetCallToCreateAnAttributeOptionForAttribute($attributeCode)
    {
        throw new PendingException();
    }


//    /**
//     * @When /^I make a direct authenticated POST call on the "([^"]*)" user group with following data:$/
//     */
//    public function iMakeADirectAuthenticatedPostCallOnTheUserGroupWithFollowingData($userGroupCode, TableNode $table)
//    {
//        $routeName = 'oro_user_group_update';
//        $params = [];
//
//        foreach ($table->getRows() as $data) {
//            $params[$data[0]] = $data[1];
//        }
//
//        $userGroup = $this->kernel
//            ->getContainer()
//            ->get('pim_user.repository.group')
//            ->findOneByIdentifier($userGroupCode);
//
//        $url = $this->kernel
//            ->getContainer()
//            ->get('router')
//            ->generate($routeName, ['id' => $userGroup->getId()]);
//
//
//        $this->doCall('POST', $url, $params);
//        var_dump($params);
//    }

    /**
     * @param string $method
     * @param string $url
     */
    private function doCall($method, $url, $data = [], $username = 'Julia')
    {
        $this->logIn($username);
        $this->client->request($method, $url, $data);

//        print_r($this->client->getResponse()->getContent());
//        print_r($this->client->getResponse()->getStatusCode());
    }

    /**
     * @param string $username
     */
    private function logIn($username = 'Julia')
    {
        // http://symfony.com/doc/current/testing/http_authentication.html

        $client = new Client($this->kernel);
        $client->disableReboot();
        $client->followRedirects();
        $this->client = $client;

        $session = $this->client->getContainer()->get('session');

        $user = $this->kernel
            ->getContainer()
            ->get('pim_user.repository.user')
            ->findOneBy(['username' => $username]);

        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $session->set('_security_main', serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
