.. index::
    single: Doctrine
    single: Managers

Doctrine base entity manager
============================

The bundle comes with an abstract class for your entities and documents managers:

* ``Sonata\CoreBundle\Model\BaseEntityManager``
* ``Sonata\CoreBundle\Model\BaseDocumentManager``
* ``Sonata\CoreBundle\Model\BasePHPCRManager``

Use it in your managers
-----------------------

You just have to extend one of the managers::

    // src/Entity/ProductManager.php

    namespace App\Entity;

    use Sonata\CoreBundle\Model\BaseEntityManager;

    class ProductManager extends BaseEntityManager
    {
        // ...
    }

