<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Mautic\UserBundle\Security\Permissions;

use Mautic\CoreBundle\Security\Permissions\AbstractPermissions;
use Mautic\UserBundle\Form\Type\PermissionListType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class UserPermissions.
 */
class UserPermissions extends AbstractPermissions
{
    /**
     * {@inheritdoc}
     */
    public function __construct($params)
    {
        parent::__construct($params);
        $this->permissions = [
            'profile' => [
                'editusername' => 1,
                'editemail'    => 2,
                'editposition' => 4,
                'editname'     => 8,
                'full'         => 1024,
            ],
        ];
        $this->addStandardPermissions('users', false);
        $this->addStandardPermissions('roles', false);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface &$builder, array $options, array $data)
    {
        $this->addStandardFormFields('user', 'users', $builder, $data, false);
        $this->addStandardFormFields('user', 'roles', $builder, $data, false);

        $builder->add(
            'user:profile',
            PermissionListType::class,
            [
                'choices'           => [
                    'mautic.user.account.permissions.editname'     => 'editname',
                    'mautic.user.account.permissions.editusername' => 'editusername',
                    'mautic.user.account.permissions.editemail'    => 'editemail',
                    'mautic.user.account.permissions.editposition' => 'editposition',
                    'mautic.user.account.permissions.editall'      => 'full',
                ],
                'label'  => 'mautic.user.permissions.profile',
                'data'   => (!empty($data['profile']) ? $data['profile'] : []),
                'bundle' => 'user',
                'level'  => 'profile',
            ]
        );
    }
}
