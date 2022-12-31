<?php


namespace App\Service\Graphql;


use Overblog\GraphQLBundle\Resolver\ResolverMap;
use ArrayObject;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\ArgumentInterface;

class CustomResolverMap extends ResolverMap
{
    public function __construct(
        private QueryService $queryService,
        private MutationService $mutationService
    ) {}

    protected function map()
    {
        return [
            'RootQuery'    => [
                self::RESOLVE_FIELD => function (
                    $value,
                    ArgumentInterface $args,
                    ArrayObject $context,
                    ResolveInfo $info
                ) {
                    return match ($info->fieldName) {
                        'user', 'reporter' => $this->queryService->findUser((int)$args['id']),
                        'findUserByEmail' => $this->queryService->findUserByEmail((string)$args['email']),
                        'users' => $this->queryService->getAllUsers(),
                        'findOrdersByUser' => $this->queryService->findOrdersByUser($args['name']),
                        'orders' => $this->queryService->findAllOrders(),
                        'order' => $this->queryService->findOrderById((int)$args['id']),
                        'vendor' => $this->queryService->findVendor((int)$args['id']),
                        'vendors' => $this->queryService->findAllVendors(),
                        'trip' => $this->queryService->findTripById((int)$args['id']),
                        'tripState' => $this->queryService->findState((int)$args['id']),
                        'tripStates' => $this->queryService->findStatesByTripId((int)$args['tripId']),
                        'delayReport' => $this->queryService->findDelayReport((int)$args['id']),
                        'delayReports' => $this->queryService->findAllDelayReports(),
                        'delayedOrder' => $this->queryService->findDelayedOrderById((int)$args['id']),
                        'delayedOrders' => $this->queryService->findAllDelayedOrders(),

                        default => null
                    };
                },
            ],
            'RootMutation' => [
                self::RESOLVE_FIELD => function (
                    $value,
                    ArgumentInterface $args,
                    ArrayObject $context,
                    ResolveInfo $info
                ) {
                    return match ($info->fieldName) {
                        'createUser' => $this->mutationService->createUser($args['user']),
                        'createVendor' => $this->mutationService->createVendor($args['vendor']),
                        'createOrder' => $this->mutationService->createOrder($args['order']),
                        'createTrip' => $this->mutationService->createTrip($args['trip']),
                        'createDelayReport' => $this->mutationService->createDelayReport($args['delayReport']),
                        'assignDelayedOrder' => $this->mutationService->assignDelayedOrder($args['delayedOrder']),
                        'autoAssignDelayedOrder' => $this->mutationService->autoAssignDelayedOrder($args['delayedOrder']),
                        default => null
                    };
                },
            ],
        ];
    }
}