<?php declare(strict_types=1);

namespace IMEdge\RrdGraph\Rpn;

use IMEdge\RrdGraph\ClassRegistry;

abstract class OperatorRegistry
{
    use ClassRegistry;

    protected const IMPLEMENTATIONS = [
        // BooleanOperator
        Equal::NAME          => Equal::class,
        GreaterOrEqual::NAME => GreaterOrEqual::class,
        GreaterThan::NAME    => GreaterThan::class,
        LessOrEqual::NAME    => LessOrEqual::class,
        LessThan::NAME       => LessThan::class,
        NotEqual::NAME       => NotEqual::class,

        IsInfinity::NAME     => IsInfinity::class,
        IsUnknown::NAME      => IsUnknown::class,

        IfElse::NAME         => IfElse::class,

        // CompareValuesOperator
        Min::NAME    => Min::class,
        MinNan::NAME => MinNan::class,
        Max::NAME    => Max::class,
        MaxNan::NAME => MaxNan::class,
        Limit::NAME  => Limit::class,

        // ArithmeticOperator
        Add::NAME      => Add::class,
        AddNan::NAME   => AddNan::class,
        Subtract::NAME => Subtract::class,
        Multiply::NAME => Multiply::class,
        Divide::NAME   => Divide::class,
        Modulo::NAME   => Modulo::class,

        Pow::NAME  => Pow::class,
        Sin::NAME  => Sin::class,
        Cos::NAME  => Cos::class,
        Log::NAME  => Log::class,
        Exp::NAME  => Exp::class,
        Sqrt::NAME => Sqrt::class,

        Atan::NAME    => Atan::class,
        Atan2::NAME   => Atan2::class,
        Floor::NAME   => Floor::class,
        Ceil::NAME    => Ceil::class,
        Deg2Rad::NAME => Deg2Rad::class,
        Rad2Deg::NAME => Rad2Deg::class,
        Abs::NAME     => Abs::class,

        // SetOperator (Set Operations)
        Sort::NAME    => Sort::class,
        Reverse::NAME => Reverse::class,
        Average::NAME => Average::class,
        SetMin::NAME  => SetMin::class,
        SetMax::NAME  => SetMax::class,
        Median::NAME  => Median::class,
        StandardDeviation::NAME => StandardDeviation::class,
        // DUP. -> StreamPercent Percent::NAME => Percent::class,
        Trend::NAME   => Trend::class,
        TrendNan::NAME => TrendNan::class,
        Predict::NAME  => Predict::class,
        PredictSigma::NAME => PredictSigma::class,
        PredictPerc::NAME  => PredictPerc::class,

        // TODO: PREDICT, PREDICTSIGMA, PREDICTPERC

        // SpecialValue
        Unknown::NAME  => Unknown::class,
        Infinite::NAME => Infinite::class,
        NegativeInfinite::NAME => NegativeInfinite::class,
        Previous::NAME => Previous::class,
        // TODO: Prev(vname)
        Count::NAME    =>  Count::class,

        // TimeValue
        Now::NAME => Now::class,
        StepWidth::NAME => StepWidth::class,
        NewDay::NAME    => NewDay::class,
        NewWeek::NAME   => NewWeek::class,
        NewMonth::NAME  => NewMonth::class,
        NewYear::NAME   => NewYear::class,
        Time::NAME      => Time::class,
        LocalTime::NAME => LocalTime::class,

        // StackOperator
        DuplicateTopStackElement::NAME => DuplicateTopStackElement::class,
        RemoveTopStackElement::NAME    => RemoveTopStackElement::class,
        ExchangeTopStackElements::NAME => ExchangeTopStackElements::class,
        Depth::NAME => Depth::class,
        Copy::NAME  => Copy::class,
        Index::NAME => Index::class,
        Roll::NAME  => Roll::class,

        // VariablesOperator
        Maximum::NAME => Maximum::class,
        Minimum::NAME => Minimum::class,
        StreamAverage::NAME => StreamAverage::class,
        // TODO: Dup. StreamStandardDeviation::NAME => StreamStandardDeviation::class,
        Last::NAME  => Last::class,
        First::NAME => First::class,
        Total::NAME => Total::class,
        // TODO: Dup.
        StreamPercent::NAME => StreamPercent::class,
        StreamPercentNan::NAME          => StreamPercentNan::class,
        LeastSquaresLineSlope::NAME     => LeastSquaresLineSlope::class,
        LeastSquaresLineIntercept::NAME => LeastSquaresLineIntercept::class,
        LeastSquaresLineCorrelationCoefficient::NAME => LeastSquaresLineCorrelationCoefficient::class,
    ];
}
