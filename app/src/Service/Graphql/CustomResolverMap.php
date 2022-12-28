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
                        'user' => $this->queryService->findUser((int)$args['id']),
                        'findUserByEmail' => $this->queryService->findUserByEmail((string)$args['email']),
                        'users' => $this->queryService->getAllUsers(),
                        'findOrdersByUser' => $this->queryService->findOrdersByUser($args['name']),
                        'orders' => $this->queryService->findAllOrders(),
                        'order' => $this->queryService->findOrderById((int)$args['id']),
                        'vendor' => $this->queryService->findVendor((int)$args['id']),
                        'vendors' => $this->queryService->findAllVendors(),
                        'delayReport' => $this->queryService->findDelayReport((int)$args['id']),
                        'delayReports' => $this->queryService->findAllDelayReports(),

                        default => null
                    };
                },
            ]
        ];
    }
}