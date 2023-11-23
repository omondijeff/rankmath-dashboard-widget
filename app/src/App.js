import React, { useState, useEffect } from "react";
import styles from "./GraphWidget.module.css";
import { LineChart, Line, XAxis, YAxis, CartesianGrid } from "recharts";

const App = () => {
  const [salesData, setSalesData] = useState([]);
  const [timeframe, setTimeframe] = useState("7");

  // Function to fetch sales data
  const fetchData = async () => {
    try {
      const response = await fetch(
        `/wp-json/rankmath/v1/sales-data?timeframe=${timeframe}`
      );
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      const data = await response.json();
      setSalesData(data);
    } catch (error) {
      console.error(
        "There has been a problem with your fetch operation:",
        error
      );
    }
  };

  // Effect to fetch data on mount and when `timeframe` changes
  useEffect(() => {
    fetchData();
  }, [timeframe]);

  // Handle timeframe selection change
  const handleTimeframeChange = (event) => {
    setTimeframe(event.target.value);
  };

  return (
    <div className={styles.graphWidget}>
      <div className={styles.widgetHeader}>
        <h2>Graph Widget</h2>
        <select value={timeframe} onChange={handleTimeframeChange}>
          <option value="7">Last 7 Days</option>
          <option value="15">Last 15 Days</option>
          <option value="30">Last 1 Month</option>
        </select>
      </div>
      <div className={styles.graphContainer}>
        <LineChart width={500} height={300} data={salesData}>
          <XAxis dataKey="date" />
          <YAxis />
          <CartesianGrid stroke="#eee" strokeDasharray="5 5" />
          <Line type="monotone" dataKey="sales" stroke="#8884d8" />
        </LineChart>
      </div>
    </div>
  );
};

export default App;
