class AbstractSVGChart {
    createPlotScaffold() {
        // get the svg root element
        const svgRoot = document.getElementById(this.element_id);

        const g_svg_plot = this.createSVGElement('g',
            {id: this.element_id + "_svg_plot", transform: "translate(0, 0)"})
        svgRoot.appendChild(g_svg_plot);

        // TOP BAR
        const g_svg_plot_top_bar = this.createSVGElement('g',
            {id: this.top_bar.element_id, transform: "translate(0, 0)"})
        const rect_svg_plot_top_bar = this.createSVGElement('rect',
            {x: "0", y: "0", width: "100%", height: "50", rx: "0", stroke: "none", fill: "black"})
        g_svg_plot.appendChild(g_svg_plot_top_bar);
        g_svg_plot_top_bar.appendChild(rect_svg_plot_top_bar);

        // BOTTOM BAR
        const g_svg_plot_bottom_bar = this.createSVGElement('g',
            {id: this.bottom_bar.element_id, transform: "translate(0, 0)"})
        const rect_svg_plot_bottom_bar = this.createSVGElement('rect',
            {x: "0", y: "550", width: "100%", height: "50", rx: "0", stroke: "none", fill: "black"});
        g_svg_plot.appendChild(g_svg_plot_bottom_bar);
        g_svg_plot_bottom_bar.appendChild(rect_svg_plot_bottom_bar);

        // CHART TITLE
        const g_svg_chart_title = this.createSVGElement('g',
            {id: this.chart_title.element_id, transform: "translate(50, 0)"})
        const rect_svg_chart_title = this.createSVGElement('rect',
            {x: "0", y: "0", width: "600", height: "50", rx: "0", stroke: "none", fill: "none"})
        const text_svg_chart_title = this.createSVGElement('text',
            {
                x: "40%",
                y: "35",
                text_anchor: "middle",
                id: this.chart_title.text_element_id,
                class: "svg-chart-title",
                textContent: "Chart Title"
            });
        g_svg_plot.appendChild(g_svg_chart_title);
        g_svg_chart_title.appendChild(rect_svg_chart_title);
        g_svg_chart_title.appendChild(text_svg_chart_title);

        // LEGEND
        const g_svg_chart_legend = this.createSVGElement('g',
            {id: this.legend.element_id, transform: "translate(650, 50)"})
        const rect_svg_chart_legend = this.createSVGElement('rect',
            {x: "0", y: "0", width: "200", height: "500", rx: "0", stroke: "none", fill: "none"});
        const text_svg_chart_legend = this.createSVGElement('text',
            {x: "5", y: "20", text_anchor: "left", class: "svg-legend-title", textContent: "Legend Title"});
        g_svg_plot.appendChild(g_svg_chart_legend);
        g_svg_chart_legend.appendChild(rect_svg_chart_legend);
        g_svg_chart_legend.appendChild(text_svg_chart_legend);

        // VERTICAL AXIS
        const g_svg_plot_vertical_axis = this.createSVGElement('g',
            {id: this.y_axis.element_id, transform: "translate(0, 50)"})
        const rect_svg_plot_vertical_axis = this.createSVGElement('rect',
            {x: "0", y: "0", width: "50", height: "500", rx: "0", stroke: "none", fill: "none"})
        const text_svg_plot_vertical_axis = this.createSVGElement('text',
            {
                id: this.y_axis.title_element_id, x: "0", y: "15", text_anchor: "middle", class: "svg-axis-title",
                transform: "translate(0,250) rotate(270)", textContent: "Vertical Axis Title"
            });
        g_svg_plot.appendChild(g_svg_plot_vertical_axis);
        g_svg_plot_vertical_axis.appendChild(rect_svg_plot_vertical_axis);
        g_svg_plot_vertical_axis.appendChild(text_svg_plot_vertical_axis);

        // HORIZONTAL AXIS
        const g_svg_plot_horizontal_axis = this.createSVGElement('g',
            {id: this.x_axis.element_id, transform: "translate(50, 550)"})
        const rect_svg_plot_horizontal_axis = this.createSVGElement('rect',
            {x: "0", y: "0", width: "600", height: "50", rx: "0", stroke: "none", fill: "none"})
        const text_svg_plot_horizontal_axis = this.createSVGElement('text',
            {
                id: this.x_axis.title_element_id, x: "300", y: "45", text_anchor: "middle",
                class: "svg-axis-title", textContent: "Horizontal Axis Title"
            });
        g_svg_plot.appendChild(g_svg_plot_horizontal_axis);
        g_svg_plot_horizontal_axis.appendChild(rect_svg_plot_horizontal_axis);
        g_svg_plot_horizontal_axis.appendChild(text_svg_plot_horizontal_axis);

        // PLOT AREA
        const g_svg_plot_chart_area = this.createSVGElement('g',
            {id: this.plot_area.element_id, transform: "translate(50, 50)"})
        const rect_svg_plot_chart_area = this.createSVGElement('rect',
            {
                x: "0",
                y: "0",
                width: "600",
                height: "500",
                rx: "0",
                stroke: this.plot_area.stroke,
                fill: this.plot_area.stroke
            })
        const g_svg_plot_chart_areas_gridlines = this.createSVGElement('g', {id: this.plot_area.gridlines_element_id})
        const g_svg_plot_chart_areas_data_series = this.createSVGElement('g', {id: this.plot_area.data_series_element_id})
        g_svg_plot.appendChild(g_svg_plot_chart_area);
        g_svg_plot_chart_area.appendChild(rect_svg_plot_chart_area);
        g_svg_plot_chart_area.appendChild(g_svg_plot_chart_areas_gridlines);
        g_svg_plot_chart_area.appendChild(g_svg_plot_chart_areas_data_series);

    }

    constructor(svg_element_id, width, height, options = {}) {
        this.lineTypes = {
            line_only: 1,
            points_only: 2,
            line_with_points: 3,
            vertical_bar: 4,
            horizontal_bar: 5, // not yet implemented
            waterfall: 6, // not yet implemented
            bubbles: 7, // not yet implemented
            radar: 8, // not yet implemented
            funnel: 9, // not yet implemented
            pie_chart: 10, // not yet implemented
            donut_chart: 11, // not yet implemented
            treemap: 11, // not yet implemented
            sunburst: 11, // not yet implemented
            boxplot: 11, // not yet implemented
        };

        this.chart_width = width;
        this.chart_height = height;
        this.element_id = svg_element_id;
        this.default_chart_title_height = 50;
        this.default_x_axis_height = 50;
        this.default_y_axis_width = 50;
        this.default_legend_width = 150;
        this.default_point_size = 4; // this is the diameter of the circle of the point
        // initialize the areas
        this.top_bar = {
            fill: 'none',
            element_id: this.element_id + "_svg_plot_top_bar"
        }
        this.bottom_bar = {
            fill: 'none',
            element_id: this.element_id + "_svg_plot_bottom_bar"
        }

        // chart title
        this.chart_title = {
            fill: 'none',
            text: 'Chart Title',
            element_id: this.element_id + "_svg_chart_title",
            text_element_id: this.element_id + "_svg_chart_title_text"
        };

        // initialize default gridlines for axes
        this.x_axis = {
            grid_lines: {
                major: {
                    num: 3,
                    show: true,
                    show_ticks: true,
                    tick_size: 4,
                    stroke: 'white',
                    stroke_width: 2,
                    stroke_dasharray: 'none'
                },
                element_id: this.element_id + '_svg_plot_chart_areas_gridlines',
            },
            fill: 'none',
            element_id: "svg_plot_horizontal_axis",
            title: "X-axis title",
            title_element_id: this.element_id + "_svg_plot_horizontal_axis_title",
            min_value: 0,
            max_value: 100,
            uom: '%',
            show_uom: true
        };
        this.x_axis.grid_lines.minor = {...this.x_axis.grid_lines.major};
        this.x_axis.grid_lines.minor.num_per_major = 4;
        this.x_axis.grid_lines.minor.num = (this.x_axis.grid_lines.major.num + 1) * this.x_axis.grid_lines.minor.num_per_major - 1;
        this.x_axis.grid_lines.minor.stroke_width = 1;
        this.x_axis.grid_lines.minor.stroke = "black";
        this.x_axis.grid_lines.minor.stroke_dasharray = "4";

        this.y_axis = {
            grid_lines: {minor: {...this.x_axis.grid_lines.minor}, major: {...this.x_axis.grid_lines.major}},
            fill: 'none',
            title: "Y-axis title",
            element_id: this.element_id + "_svg_plot_vertical_axis",
            title_element_id: this.element_id + "_svg_plot_vertical_axis_title",
            min_value: 0,
            max_value: 100,
            uom: '%',
            show_uom: true

        };
        this.legend = {
            fill: 'none',
            element_id: "svg_legend",
            title: {
                title: "Legend",
                element_id: this.element_id + "_svg-legend-title"
            }
        };

        this.plot_area = {
            fill: 'lightgray',
            stroke: 'black',
            stroke_width: '0',
            element_id: this.element_id + 'svg_plot_chart_area',
            data_series_element_id: this.element_id + '_svg_plot_chart_areas_data_series',
            gridlines_element_id: this.element_id + '_svg_plot_chart_areas_gridlines'
        };

        this.data_series = []; // array of data series

        // create the key hooks underneath the svg
        this.createPlotScaffold();
        this.updatePlotSettings(options);

    }

    updateChartDimensions() {
        // update chart dimensions based on configuration
        // update the chart title
        const chartTitleElem = document.getElementById(this.chart_title.element_id);
        chartTitleElem.setAttribute("transform", "translate(" + this.chart_title.x.toString() + ", " + this.chart_title.y.toString() + ")");
        const chartTitleRect = chartTitleElem.getElementsByTagName("rect")[0];
        chartTitleRect.setAttribute("width", this.plot_area.width.toString());
        chartTitleRect.setAttribute("height", this.chart_title.height.toString());

        chartTitleRect.setAttribute('fill', this.chart_title.fill)
        const chartTitleText = chartTitleElem.getElementsByTagName("text")[0];
        chartTitleText.setAttribute("x", (0.5 * this.plot_area.width).toString());
        if (this.chart_title.height === 0) {
            chartTitleText.setAttribute("visibility", "hidden");
        } else {
            chartTitleText.setAttribute("visibility", "visible");
        }

        // update the top bar
        const chartPlotTopBar = document.getElementById(this.top_bar.element_id);
        const chartPlotTopBarRect = chartPlotTopBar.getElementsByTagName("rect")[0];
        chartPlotTopBarRect.setAttribute("width", this.chart_width.toString());
        chartPlotTopBarRect.setAttribute("height", this.chart_title.height.toString());
        chartPlotTopBarRect.setAttribute("fill", this.top_bar.fill);

        // update the bottom bar
        const chartPlotBottomBar = document.getElementById(this.bottom_bar.element_id);
        const chartPlotBottomBarRect = chartPlotBottomBar.getElementsByTagName("rect")[0];
        chartPlotBottomBarRect.setAttribute("width", this.chart_width.toString());
        chartPlotBottomBarRect.setAttribute("height", this.chart_title.height.toString());
        chartPlotBottomBarRect.setAttribute("fill", this.bottom_bar.fill);

        // update the chart plot area
        const chartPlotArea = document.getElementById(this.plot_area.element_id);
        chartPlotArea.setAttribute("transform", "translate(" + this.plot_area.x.toString() + ", " + this.plot_area.y.toString() + ")");
        const chartPlotAreaRect = chartPlotArea.getElementsByTagName("rect")[0];
        chartPlotAreaRect.setAttribute('fill', this.plot_area.fill)
        chartPlotAreaRect.setAttribute("width", this.plot_area.width.toString());
        chartPlotAreaRect.setAttribute("height", this.plot_area.height.toString());

        // update the chart plot area
        const chartXAxis = document.getElementById(this.x_axis.element_id);
        chartXAxis.setAttribute("transform", "translate(" + this.x_axis.x.toString() + ", " + this.x_axis.y.toString() + ")");
        const chartXAxisRect = chartXAxis.getElementsByTagName("rect")[0];
        chartXAxisRect.setAttribute("width", this.x_axis.width.toString());
        chartXAxisRect.setAttribute("height", this.x_axis.height.toString());
        chartXAxisRect.setAttribute("fill", this.x_axis.fill);
        const xAxisText = chartXAxis.getElementsByTagName("text")[0];
        xAxisText.setAttribute("x", (0.5 * this.plot_area.width).toString());
        if (this.x_axis.height === 0) {
            xAxisText.setAttribute("visibility", "hidden");
        } else {
            xAxisText.setAttribute("visibility", "visible");
        }

        // update the chart plot area
        const chartYAxis = document.getElementById(this.y_axis.element_id);
        chartYAxis.setAttribute("transform", "translate(" + this.y_axis.x.toString() + ", " + this.y_axis.y.toString() + ")");
        const chartYAxisRect = chartYAxis.getElementsByTagName("rect")[0];
        chartYAxisRect.setAttribute("width", this.y_axis.width.toString());
        chartYAxisRect.setAttribute("height", this.y_axis.height.toString());
        chartYAxisRect.setAttribute("fill", this.y_axis.fill);

        const yAxisText = chartYAxis.getElementsByTagName("text")[0];
        yAxisText.setAttribute("transform", "translate(0," + (this.plot_area.height / 2).toString() + ") rotate(270)");
        if (this.y_axis.width === 0) {
            yAxisText.setAttribute("visibility", "hidden");
        } else {
            yAxisText.setAttribute("visibility", "visible");
        }

        // update the chart legend area
        const chartLegend = document.getElementById(this.legend.element_id);
        chartLegend.setAttribute("transform", "translate(" + this.legend.x.toString() + ", " + this.legend.y.toString() + ")");
        const chartLegendRect = chartLegend.getElementsByTagName("rect")[0];
        chartLegendRect.setAttribute("width", this.legend.width.toString());
        chartLegendRect.setAttribute("height", this.legend.height.toString());
        chartLegendRect.setAttribute("fill", this.legend.fill);

        // yAxisText.setAttribute("y", (0.5 * this.plot_area.height).toString());
        const chartLegendText = chartLegend.getElementsByTagName("text")[0];

        if (this.legend.width === 0) {
            chartLegendText.setAttribute("visibility", "hidden");
        } else {
            chartLegendText.setAttribute("visibility", "visible");
        }
    }

    plotGridlines() {

        // determine the scale appropriate
        const plotAreaElem = document.getElementById(this.plot_area.element_id);
        const plotAreaRectElem = plotAreaElem.getElementsByTagName('rect')[0];
        plotAreaRectElem.setAttribute('stroke', this.plot_area.stroke);
        plotAreaRectElem.setAttribute('stroke-width', this.plot_area.stroke_width);

        // this plot the grid lines and tick marks
        // this.plot_area.gridlines_element_id;
        const plotAreaGridLinesElem = document.getElementById(this.plot_area.gridlines_element_id);
        plotAreaGridLinesElem.innerHTML = '';

        const x_major_gap_between_grid_lines = this.plot_area.width / (this.x_axis.grid_lines.major.num + 1);
        const x_minor_gap_between_grid_lines = this.plot_area.width / (this.x_axis.grid_lines.minor.num + 1);
        const y_major_gap_between_grid_lines = this.plot_area.height / (this.y_axis.grid_lines.major.num + 1);
        const y_minor_gap_between_grid_lines = this.plot_area.height / (this.y_axis.grid_lines.minor.num + 1);

        // plot minor tick sized
        // plot minor gridlines along the x-axis
        if (this.x_axis.grid_lines.minor.show) {
            for (let i = 0; i < this.x_axis.grid_lines.minor.num; i++) {
                const gridLine = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                gridLine.setAttribute('stroke', this.x_axis.grid_lines.minor.stroke);
                gridLine.setAttribute('stroke-width', this.x_axis.grid_lines.minor.stroke_width);
                gridLine.setAttribute('stroke-dasharray', this.x_axis.grid_lines.minor.stroke_dasharray);
                gridLine.setAttribute("x1", (x_minor_gap_between_grid_lines * (i + 1)).toString());
                gridLine.setAttribute("y1", "0");
                gridLine.setAttribute("x2", (x_minor_gap_between_grid_lines * (i + 1)).toString());
                gridLine.setAttribute("y2", this.plot_area.height.toString());
                gridLine.classList.add("gridlines");
                plotAreaGridLinesElem.appendChild(gridLine);
            }
        }
        // plot minor tick marks along the x-axis
        if (this.x_axis.grid_lines.minor.show_ticks) {
            for (let i = 0; i < this.x_axis.grid_lines.minor.num; i++) {
                const gridLine = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                gridLine.setAttribute('stroke', this.x_axis.grid_lines.minor.stroke);
                gridLine.setAttribute('stroke-width', this.x_axis.grid_lines.minor.stroke_width);
                gridLine.setAttribute("x1", (x_minor_gap_between_grid_lines * (i + 1)).toString());
                gridLine.setAttribute("y1", this.plot_area.height.toString());
                gridLine.setAttribute("x2", (x_minor_gap_between_grid_lines * (i + 1)).toString());
                gridLine.setAttribute("y2", (this.plot_area.height + this.x_axis.grid_lines.minor.tick_size).toString());
                gridLine.classList.add("gridlines");
                plotAreaGridLinesElem.appendChild(gridLine);
            }
        }
        // plot minor gridlines along the y-axis
        if (this.y_axis.grid_lines.minor.show) {
            for (let i = 0; i < this.y_axis.grid_lines.minor.num; i++) {
                const gridLine = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                gridLine.setAttribute('stroke', this.y_axis.grid_lines.minor.stroke);
                gridLine.setAttribute('stroke-width', this.y_axis.grid_lines.minor.stroke_width);
                gridLine.setAttribute('stroke-dasharray', this.y_axis.grid_lines.minor.stroke_dasharray);
                gridLine.setAttribute("x1", "0");
                gridLine.setAttribute("y1", (y_minor_gap_between_grid_lines * (i + 1)).toString());
                gridLine.setAttribute("x2", this.plot_area.width.toString());
                gridLine.setAttribute("y2", (y_minor_gap_between_grid_lines * (i + 1)).toString());
                gridLine.classList.add("gridlines");
                plotAreaGridLinesElem.appendChild(gridLine);
            }
        }
        // plot minor tick marks along the y-axis
        if (this.y_axis.grid_lines.minor.show_ticks) {
            for (let i = 0; i < this.x_axis.grid_lines.minor.num; i++) {
                const gridLine = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                gridLine.setAttribute('stroke', this.x_axis.grid_lines.minor.stroke);
                gridLine.setAttribute('stroke-width', this.x_axis.grid_lines.minor.stroke_width);
                gridLine.setAttribute("x1", (-this.y_axis.grid_lines.minor.tick_size).toString());
                gridLine.setAttribute("y1", (y_minor_gap_between_grid_lines * (i + 1)).toString());
                gridLine.setAttribute("x2", "0");
                gridLine.setAttribute("y2", (y_minor_gap_between_grid_lines * (i + 1)).toString());
                gridLine.classList.add("gridlines");
                plotAreaGridLinesElem.appendChild(gridLine);
            }
        }

        // plot major gridlines along the x-axis
        if (this.x_axis.grid_lines.major.show) {
            for (let i = 0; i < this.x_axis.grid_lines.major.num; i++) {
                const gridLine = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                gridLine.setAttribute('stroke', this.x_axis.grid_lines.major.stroke);
                gridLine.setAttribute('stroke-width', this.x_axis.grid_lines.major.stroke_width);
                gridLine.setAttribute('stroke-dasharray', this.x_axis.grid_lines.major.stroke_dasharray);
                gridLine.setAttribute("x1", (x_major_gap_between_grid_lines * (i + 1)).toString());
                gridLine.setAttribute("y1", "0");
                gridLine.setAttribute("x2", (x_major_gap_between_grid_lines * (i + 1)).toString());
                gridLine.setAttribute("y2", this.plot_area.height.toString());
                gridLine.classList.add("gridlines");
                plotAreaGridLinesElem.appendChild(gridLine);
            }
        }
        // draw major tick marks  on the x-axis
        if (this.x_axis.grid_lines.major.show_ticks) {
            for (let i = 0; i < this.x_axis.grid_lines.major.num; i++) {
                const gridLine = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                gridLine.setAttribute('stroke', this.x_axis.grid_lines.major.stroke);
                gridLine.setAttribute('stroke-width', this.x_axis.grid_lines.major.stroke_width);
                gridLine.setAttribute("x1", (x_major_gap_between_grid_lines * (i + 1)).toString());
                gridLine.setAttribute("y1", this.plot_area.height.toString());
                gridLine.setAttribute("x2", (x_major_gap_between_grid_lines * (i + 1)).toString());
                gridLine.setAttribute("y2", (this.plot_area.height + this.x_axis.grid_lines.minor.tick_size).toString());
                gridLine.classList.add("gridlines");
                plotAreaGridLinesElem.appendChild(gridLine);
            }
        }
        // draw major grid lines on the x-axis
        if (this.y_axis.grid_lines.major.show) {
            for (let i = 0; i < this.y_axis.grid_lines.major.num; i++) {
                const gridLine = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                gridLine.setAttribute('stroke', this.y_axis.grid_lines.major.stroke);
                gridLine.setAttribute('stroke-width', this.y_axis.grid_lines.major.stroke_width);
                gridLine.setAttribute('stroke-dasharray', this.y_axis.grid_lines.major.stroke_dasharray);
                gridLine.setAttribute("y1", (y_major_gap_between_grid_lines * (i + 1)).toString());
                gridLine.setAttribute("x1", "0");
                gridLine.setAttribute("y2", (y_major_gap_between_grid_lines * (i + 1)).toString());
                gridLine.setAttribute("x2", this.plot_area.width.toString());
                gridLine.classList.add("gridlines");
                plotAreaGridLinesElem.appendChild(gridLine);
            }
        }
        // draw major tick marks  on the y-axis
        if (this.y_axis.grid_lines.major.show_ticks) {
            for (let i = 0; i < this.x_axis.grid_lines.major.num; i++) {
                const gridLine = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                gridLine.setAttribute('stroke', this.y_axis.grid_lines.major.stroke);
                gridLine.setAttribute('stroke-width', this.y_axis.grid_lines.major.stroke_width);
                gridLine.setAttribute("x1", (-this.y_axis.grid_lines.major.tick_size).toString());
                gridLine.setAttribute("y1", (y_major_gap_between_grid_lines * (i + 1)).toString());
                gridLine.setAttribute("x2", "0");
                gridLine.setAttribute("y2", (y_major_gap_between_grid_lines * (i + 1)).toString());
                gridLine.classList.add("gridlines");
                plotAreaGridLinesElem.appendChild(gridLine);


            }
        }

        for (let i = 0; i < this.y_axis.grid_lines.major.num + 2; i++) {
            const tickText = document.createElementNS('http://www.w3.org/2000/svg', 'text');
            tickText.setAttribute("x", (-7).toString());
            tickText.setAttribute("y", (y_major_gap_between_grid_lines * (i)).toString());
            tickText.setAttribute("text-anchor", 'end');
            tickText.classList.add('svg-tick-mark-label');
            const tick_value = this.y_axis.min_value + (this.y_axis.grid_lines.major.num - i + 1) * (this.y_axis.max_value - this.y_axis.min_value) / (this.y_axis.grid_lines.major.num + 1);
            tickText.innerHTML = tick_value;
            plotAreaGridLinesElem.appendChild(tickText);
        }
        for (let i = 0; i < this.x_axis.grid_lines.major.num + 2; i++) {
            const tickText = document.createElementNS('http://www.w3.org/2000/svg', 'text');

            tickText.setAttribute("x", (x_major_gap_between_grid_lines * (i)).toString());
            tickText.setAttribute("y", (this.plot_area.height + 25).toString());
            tickText.setAttribute("text-anchor", 'middle');
            tickText.classList.add('svg-tick-mark-label');


            const tick_value = this.x_axis.min_value + (i) * (this.x_axis.max_value - this.x_axis.min_value) / (this.x_axis.grid_lines.major.num + 1);
            tickText.innerHTML = tick_value;
            plotAreaGridLinesElem.appendChild(tickText);
        }
    }

    /* THIS SHOULD BE MOVED TO LINE CHART */
    plotDataSeries() {
        const dataSeriesElement = document.getElementById(this.plot_area.data_series_element_id);
        // remove previous data series to redraw
        dataSeriesElement.innerHTML = '';
        this.data_series.forEach((series, index) => {
            // add legend entry
            // TODO: implement legend entries
            // initialize
            // console.log(series == this.lineTypes.line_with_points);

            if (series.line_type == this.lineTypes.vertical_bar) {
                this.plotVerticalBarSeries(dataSeriesElement, series);
            }
            if (series.line_type == this.lineTypes.line_with_points || series.line_type == this.lineTypes.line_only) {
                this.plotLineSeries(dataSeriesElement, series);
            }
            if (series.line_type == this.lineTypes.line_with_points || series.line_type == this.lineTypes.points_only) {
                this.plotPointsSeries(dataSeriesElement, series);
            }
            // convert x to chart coordinates

        });
    }

    plotLineSeries(dataSeriesElement, series) {
        let last_point = null;
        let poly_line_points = new Array();
        series.points.forEach((point, point_index) => {
            poly_line_points.push(this.getXCoordinate(point.x) + ',' + this.getYCoordinate(point.y));
            if (last_point !== null) {
                const lineElem = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                lineElem.setAttribute('x1', this.getXCoordinate(last_point.x));
                lineElem.setAttribute('y1', this.getYCoordinate(last_point.y));
                lineElem.setAttribute('x2', this.getXCoordinate(point.x));
                lineElem.setAttribute('y2', this.getYCoordinate(point.y));
                lineElem.setAttribute('stroke', series.line_stroke);
                lineElem.setAttribute('stroke-width', series.line_stroke_width.toString());
                // dataSeriesElement.appendChild(lineElem);
            }
            last_point = point;
        });
        const polyLineElem = document.createElementNS('http://www.w3.org/2000/svg', 'polyline');
        polyLineElem.setAttribute('points', poly_line_points.join(' '));
        polyLineElem.setAttribute('stroke', series.line_stroke);
        // polyLineElem.setAttribute('stroke', "yellow");
        polyLineElem.setAttribute('fill', 'none');
        polyLineElem.setAttribute('stroke-width', series.line_stroke_width.toString());
        // polyLineElem.setAttribute('stroke-width', "10");
        dataSeriesElement.appendChild(polyLineElem);

    }

    plotPointsSeries(dataSeriesElement, series) {
        // let last_point = null;
        let poly_line_points = new Array();
        series.points.forEach((point, point_index) => {
            // create a marker based on configuration. If not set a color will be set
            const pointElem = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
            pointElem.setAttribute('r', (series.point_size).toString());
            pointElem.setAttribute('stroke', series.point_stroke);
            pointElem.setAttribute('stroke-width', series.point_stroke_width);
            pointElem.setAttribute('fill', series.point_fill);
            pointElem.setAttribute('cx', this.getXCoordinate(point.x));
            pointElem.setAttribute('cy', this.getYCoordinate(point.y));
            dataSeriesElement.appendChild(pointElem);
            // last_point = point;
        });

    }

    plotVerticalBarSeries(dataSeriesElement, series) {
        // let last_point = null;
        let poly_line_points = new Array();

        const default_bar_margin = 30;
        const bar_width = (this.plot_area.width - default_bar_margin * (series.points.length+1))/series.points.length;
        console.log(bar_width);

        const fill_color = this
        series.points.forEach((point, point_index) => {
            // create a bar for each
            const bar_height = this.plot_area.height- this.getYCoordinate(point.y);
            const barElem = this.createSVGElement('rect',
                {
                    x: point_index * bar_width + (point_index +1) * default_bar_margin,
                    y:  this.plot_area.height - bar_height,
                    width: bar_width, height: bar_height,
                    fill: series.fill, fill_opacity: series.fill_opacity,
                    stroke: series.line_stroke, stroke_width: series.line_stroke_width}
            );
            // create a rectangle
            dataSeriesElement.appendChild(barElem);
            // last_point = point;
        });
    }

    getXCoordinate(x_value) {
        return x_value * this.plot_area.width / (this.x_axis.max_value - this.x_axis.min_value);
    }

    getYCoordinate(y_value) {
        return this.plot_area.height - y_value * this.plot_area.height / (this.y_axis.max_value - this.y_axis.min_value);
    }

    plotChart() {
        this.updateChartDimensions();
        this.plotTitle();
        this.plotAxes();
        this.plotLegend();
        this.plotGridlines();
        this.plotDataSeries();
    }

    plotTitle() {
        const titleText = document.getElementById(this.chart_title.text_element_id);
        titleText.textContent = this.chart_title.text;
    }

    plotAxes() {
        const xTitleText = document.getElementById(this.x_axis.title_element_id);
        xTitleText.textContent = this.x_axis.title + (this.x_axis.show_uom ? ' (' + this.x_axis.uom + ')' : '');
        const yTitleText = document.getElementById(this.y_axis.title_element_id);
        yTitleText.textContent = this.y_axis.title + (this.y_axis.show_uom ? ' (' + this.y_axis.uom + ')' : '');
        ;

    }

    plotLegend() {
    }

    /**
     * Expecting a data_series in the following format
     * {
     *      name: 'Data Series Name', // used in the legend for example
     *      type: 'line||points
     *      points: [
     *          {x: 'x_value', y: 'y_value', label: 'Optional Label for point', onclick: 'Optional onclick function', details: {optional_object with more details}}
     *      ]
     *
     * }
     * @param series
     */
    addDataSeries(line_type, data) {
        data.max_y_value = Math.max(...data.points.map(o => o.y));
        data.min_y_value = Math.min(...data.points.map(o => o.y));
        data.max_x_value = Math.max(...data.points.map(o => o.x));
        data.min_x_value = Math.min(...data.points.map(o => o.x));
        data.line_type = line_type;

        if (!this.x_axis.hasOwnProperty("max_value") || this.x_axis.max_value < data.max_x_value) {
            this.x_axis.max_value = data.max_x_value;
        }
        if (!this.x_axis.hasOwnProperty("min_value") || this.x_axis.min_value > data.min_x_value) {
            this.x_axis.min_value = data.min_x_value;
        }
        if (!this.y_axis.hasOwnProperty("max_value") || this.y_axis.max_value < data.max_y_value) {
            this.y_axis.max_value = data.max_y_value;
        }
        if (!this.y_axis.hasOwnProperty("min_value") || this.y_axis.min_value > data.min_y_value) {
            this.y_axis.min_value = data.min_y_value;
        }

        // below set the ideal
        const x_range = this.x_axis.max_value - this.x_axis.min_value;
        let factor = 10;
        const x_delta_major_grid_lines = Math.ceil(x_range / (this.x_axis.grid_lines.major.num + 1) / factor) * factor;
        this.x_axis.max_value = (this.x_axis.grid_lines.major.num + 1) * x_delta_major_grid_lines;
        const y_range = this.y_axis.max_value - this.y_axis.min_value;
        factor = 25;

        const y_delta_major_grid_lines = Math.ceil(y_range / (this.y_axis.grid_lines.major.num + 1) / factor) * factor;
        this.y_axis.max_value = (this.y_axis.grid_lines.major.num + 1) * y_delta_major_grid_lines;

        if (line_type === this.lineTypes.points_only || line_type === this.lineTypes.line_with_points) {
            data.point_size = data.hasOwnProperty('point_size') ? data.point_size : this.default_point_size;
            data.point_fill = data.hasOwnProperty('point_fill') ? data.point_fill : this.getDefaultColor(this.data_series.length);
            data.point_stroke = data.hasOwnProperty('point_stroke') ? data.point_stroke : this.getDefaultColor(this.data_series.length);
            data.point_stroke_width = data.hasOwnProperty('point_stroke_width') ? data.point_stroke_width : "1";
        } else {
            data.point_size = 0;
        }
        if (line_type === this.lineTypes.line_only || line_type === this.lineTypes.line_with_points) {
            data.line_stroke = data.hasOwnProperty('line_stroke') ? data.line_stroke : this.getDefaultColor(this.data_series.length);
            data.line_stroke_width = data.hasOwnProperty('line_stroke_width') ? data.line_stroke_width : "1";
        } else {
            data.point_size = 0;
        }
        if (line_type == this.lineTypes.vertical_bar || line_type == this.lineTypes.horizontal_bar){
            data.line_stroke = data.hasOwnProperty('line_stroke') ? data.line_stroke : this.getDefaultColor(this.data_series.length);
            data.line_stroke_width = data.hasOwnProperty('line_stroke_width') ? data.line_stroke_width : "1";
            data.fill = data.hasOwnProperty('fill') ? data.fill : this.getDefaultColor(this.data_series.length);
            data.fill_opacity = data.hasOwnProperty('fill_opacity') ? data.fill_opacity : "100%";
        }

        this.data_series.push(data);
    }

    getDefaultColor(index) {
        // this function generates a default color cycling through a list
        const default_colors =
            ['red', 'green', 'blue', 'orange', 'grey', 'black', '#3B82A2', '#EFCA70', '#6A4F79', '#A9D675', '#BB5039', '#F2A464', '#9FDBD0'];
        const color_index = index % default_colors.length;
        return default_colors[color_index];
    }

    updatePlotSettings(options) {

        // this function set the plot settings

        this.chart_width = options.hasOwnProperty("chart_width") ? options.chart_width : this.chart_width;
        this.chart_height = options.hasOwnProperty("chart_height") ? options.chart_height : this.chart_height;
        const chart_title_height = options.hasOwnProperty("chart_title_height") ? options.chart_title_height :
            (this.chart_title.hasOwnProperty("height") ? this.chart_title.height : this.default_chart_title_height);
        const x_axis_height = options.hasOwnProperty("x_axis_height") ? options.x_axis_height :
            (this.x_axis.hasOwnProperty("height") ? this.x_axis.height : this.default_x_axis_height);
        const y_axis_width = options.hasOwnProperty("y_axis_width") ? options.y_axis_width :
            (this.y_axis.hasOwnProperty("width") ? this.y_axis.width : this.default_y_axis_width);
        const legend_width = options.hasOwnProperty("legend_width") ? options.legend_width :
            (this.legend.hasOwnProperty("width") ? this.legend.width : this.default_legend_width);

        const plot_area_width = this.chart_width - y_axis_width - legend_width;
        const plot_area_height = this.chart_height - x_axis_height - chart_title_height;
        /* define the 5 key blocks of the graph */
        this.chart_title.x = y_axis_width;
        this.chart_title.y = 0;
        this.chart_title.height = chart_title_height;

        this.x_axis.x = y_axis_width;
        this.x_axis.y = chart_title_height + plot_area_height;
        this.x_axis.width = this.chart_width - y_axis_width - legend_width;
        this.x_axis.height = x_axis_height;

        this.y_axis.x = 0;
        this.y_axis.y = chart_title_height;
        this.y_axis.width = y_axis_width;
        this.y_axis.height = this.chart_height - chart_title_height - x_axis_height;

        this.legend.x = y_axis_width + plot_area_width;
        this.legend.y = chart_title_height;
        this.legend.width = legend_width;
        this.legend.height = this.chart_height - this.chart_title.height - this.x_axis.height;


        this.plot_area.x = y_axis_width;
        this.plot_area.y = chart_title_height;
        this.plot_area.width = plot_area_width;
        this.plot_area.height = plot_area_height;

        // this.plotChart();

    }

    hideLegend() {
        // set the width of the legend to 0 ?? Where do we store the last value so
        this.legend.previous_width = this.legend.width;
        this.legend.width = 0;
        this.updatePlotSettings({});
        this, this.plotChart();
    }

    showLegend() {
        if (this.legend.width === 0) {
            this.legend.width = this.legend.hasOwnProperty("previous_width") ? this.legend.previous_width : this.default_legend_width;
        }
        this.updatePlotSettings({});
        this.plotChart();
    }

    hideChartTitle() {
        // set the width of the legend to 0 ?? Where do we store the last value so
        this.chart_title.previous_height = this.chart_title.height;
        this.chart_title.height = 0;
        this.updatePlotSettings({});
        this.plotChart();
    }

    showChartTitle() {
        if (this.chart_title.height === 0) {
            this.chart_title.height = this.legend.hasOwnProperty("previous_height") ? this.chart_title.previous_height : this.default_chart_title_height;
        }
        this.updatePlotSettings({});
        this.plotChart();
    }

    hideXAxis() {
        this.x_axis.previous_height = this.x_axis.height;
        this.x_axis.height = 0;
        this.updatePlotSettings({});
        this.plotChart();
    }

    showXAxis() {
        if (this.x_axis.height === 0) {
            this.x_axis.height = this.x_axis.hasOwnProperty("previous_height") ? this.x_axis.previous_height : this.default_x_axis_height;
        }
        this.updatePlotSettings({});
        this.plotChart();
    }

    hideYAxis() {
        this.y_axis.previous_width = this.y_axis.width;
        this.y_axis.width = 0;
        this.updatePlotSettings({});
        this.plotChart();
    }

    showYAxis() {
        if (this.y_axis.width === 0) {
            this.y_axis.width = this.y_axis.hasOwnProperty("previous_width") ? this.y_axis.previous_width : this.default_y_axis_width;
        }
        this.updatePlotSettings({});
        this.plotChart();
    }

    setPlotAreaSquare() {
        if (this.plot_area.height !== this.plot_area.width) {
            if (this.plot_area.height < this.plot_area.width) {
                // adjust the legend to make it wider
                this.legend.width = this.legend.width + this.plot_area.width - this.plot_area.height;
            } else {
                this.x_axis.height = this.legend.width + this.plot_area.height - this.plot_area.width;
            }
            this.updatePlotSettings({});
            this.plotChart();
        }
    }

    createSVGElement(tag_name, elemAttributes) {
        const element = document.createElementNS('http://www.w3.org/2000/svg', tag_name);
        Object.keys(elemAttributes).forEach(attribute => {
            if (attribute === 'textContent') {
                element.textContent = elemAttributes[attribute];
            } else {
                element.setAttribute(attribute.replaceAll('_', '-'), elemAttributes[attribute]);
            }
        });
        return element;
    }
}

class SVGLineChart extends AbstractSVGChart {
    constructor(plot_id, width, height, options) {
        super(plot_id, width, height, options);
    }


}

class SVGBarChart extends AbstractSVGChart {
    constructor(plot_id, width, height, options) {
        super(plot_id, width, height, options);
    }
}
