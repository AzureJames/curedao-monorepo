<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\SolutionProviders;

use Facade\Ignition\Support\ComposerClassMap;
use Facade\Ignition\Support\StringComparator;
use Facade\IgnitionContracts\BaseSolution;
use Facade\IgnitionContracts\HasSolutionsForThrowable;
use Illuminate\Support\Str;
use Throwable;
use UnexpectedValueException;

class QMInvalidRouteActionSolutionProvider implements HasSolutionsForThrowable
{
    protected const REGEX = '/\[([a-zA-Z\\\\]+)\]/m';

    public function canSolve(Throwable $throwable): bool
    {
        if (! $throwable instanceof UnexpectedValueException) {
            return false;
        }

        if (! preg_match(self::REGEX, $throwable->getMessage(), $matches)) {
            return false;
        }

        return Str::startsWith($throwable->getMessage(), 'Invalid route action: ');
    }

    public function getSolutions(Throwable $throwable): array
    {
        preg_match(self::REGEX, $throwable->getMessage(), $matches);

        $invalidController = $matches[1] ?? null;

        $suggestedController = $this->findRelatedController($invalidController);

        if ($suggestedController === $invalidController) {
            return [
                BaseSolution::create("`{$invalidController}` is not invokable.")
                    ->setSolutionDescription("The controller class `{$invalidController}` is not invokable. Did you forget to add the `__invoke` method or is the controller's method missing in your routes file?"),
            ];
        }

        if ($suggestedController) {
            return [
                BaseSolution::create("`{$invalidController}` was not found.")
                    ->setSolutionDescription("Controller class `{$invalidController}` for one of your routes was not found. Did you mean `{$suggestedController}`?"),
            ];
        }

        return [
            BaseSolution::create("`{$invalidController}` was not found.")
                ->setSolutionDescription("Controller class `{$invalidController}` for one of your routes was not found. Are you sure this controller exists and is imported correctly?"),
        ];
    }

    protected function findRelatedController(string $invalidController): ?string
    {
        $composerClassMap = app(ComposerClassMap::class);

        $controllers = collect($composerClassMap->listClasses())
            ->filter(function (string $file, string $fqcn) {
                return Str::endsWith($fqcn, 'Controller');
            })
            ->mapWithKeys(function (string $file, string $fqcn) {
                return [$fqcn => class_basename($fqcn)];
            })
            ->toArray();

        $basenameMatch = StringComparator::findClosestMatch($controllers, $invalidController, 4);

        $controllers = array_flip($controllers);

        $fqcnMatch = StringComparator::findClosestMatch($controllers, $invalidController, 4);

        return $fqcnMatch ?? $basenameMatch;
    }
}
